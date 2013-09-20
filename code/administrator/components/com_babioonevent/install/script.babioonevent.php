<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$file = dirname(__FILE__) . '/helper.php';

if (!file_exists($file))
{
	die('can not find install helper file');
}
require $file;


/**
 * Script file of com_babioonevent component
 *
 * @package  BABIOON_EVENT
 * @since    2.0.0
 */
class Com_BabiooneventInstallerScript
{

	/** @var string The component's name */
	protected $babioon_extension = 'com_babioonevent';

	/** @var string min Joomla Version to install on */
	protected $minJVersion   = '2.5.9';

	/** @var string min php version to install on */
	protected $minPhpVersion = '5.3.1';

	/** @var array The list of extra modules and plugins to install */
	protected $installation_queue = array(
		// Modules => { (folder) => { (module) => { (position), (published) } }* }*
		'modules' => array(
			'admin' => array(
			),
			'site' => array(
				'babioonevent_eventlist' => array('none', 0)
			)
		),
		// Plugins => { (folder) => { (element) => (published) }* }*
		'plugins' => array(
			'search' => array(
				'babioonevent'				=> 0
			)
		)
	);

	/**
	 * method to install the component
	 *
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return void
	 */
	function install($parent)
	{
	}

	/**
	 * method to install the component
	 *
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return void
	 */
	function discover_install($parent)
	{
	}

	/**
	 * method to uninstall the component
	 *
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// Uninstall subextensions
		$status = BabioonInstallHelper::uninstallSubextensions($parent, $this->installation_queue);
		$this->_renderPostUninstallation($status, $parent);
	}

	/**
	 * method to update the component
	 *
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return void
	 */
	function update($parent)
	{
		// Not so much to do now
	}

	/**
	 * Joomla! pre-flight event
	 *
	 * @param   string      $type    Installation type (install, update, discover_install)
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return boolean
	 */
	public function preflight($type, $parent)
	{
		$message       = array();

		if (!version_compare(JVERSION, $this->minJVersion, 'ge'))
		{
			$msg = "<p>You need Joomla! $this->minJVersion or later to install this component</p>";
			JError::raiseWarning(100, $msg);

			return false;
		}

		// Only allow to install on min[J|Php]Version or later
		if (defined('PHP_VERSION'))
		{
			$version = PHP_VERSION;
		}
		elseif (function_exists('phpversion'))
		{
			$version = phpversion();
		}
		else
		{
			// Pfff, ok then we take the risk but we'll send a message about not getting the info
			$message[] = "<p>We couldn't get information about the PHP Version we assume that you have $this->minPhpVersion or later</p>";
			$version   = $this->minPhpVersion;
		}

		if (!version_compare($version, $this->minPhpVersion, 'ge'))
		{
			$message[] = "<p>You need PHP $this->minPhpVersion or later to install this component</p>";
			$msg = implode('', $message);

			if (version_compare(JVERSION, '3.0', 'gt'))
			{
				JLog::add($msg, JLog::WARNING, 'jerror');
			}
			else
			{
				JError::raiseWarning(100, $msg);
			}
			return false;
		}

		// Only install on mysql
		$dbTargets = array('mysql','mysqli');
		$dbDriver = strtolower(JFactory::getDBO()->name);

		if (!in_array($dbDriver, $dbTargets))
		{
			$msg = "<p>You need a mysql Database to install this component</p>";

			if (version_compare(JVERSION, '3.0', 'gt'))
			{
				JLog::add($msg, JLog::WARNING, 'jerror');
			}
			else
			{
				JError::raiseWarning(100, $msg);
			}
			return false;
		}

		if (strtolower($type) == 'update')
		{
			$toVersion = $parent->get("manifest")->version;
		}

		// Bugfix for certain installer features
		if (in_array($type, array('install')))
		{
			BabioonInstallHelper::bugfixDBFunctionReturnedNoError($this->babioon_extension);
		}
		else
		{
			BabioonInstallHelper::bugfixCantBuildAdminMenus($this->babioon_extension);
			BabioonInstallHelper::fixSchemaVersion($this->babioon_extension);
			BabioonInstallHelper::fixBrokenSQLUpdates($this->babioon_extension, $parent);
		}

		return true;
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @param   string      $type    Installation type (install, update, discover_install)
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)

		$status = new stdClass;
		$status->fof = '';
		$status->subextensions = '';

		if ($type != 'discover_install')
		{
			// Install subextensions
			$status->subextensions = BabioonInstallHelper::installSubextensions($parent, $this->installation_queue);
		}

		if (version_compare(JVERSION, '3.2.0', 'lt'))
		{
			$status->fof = BabioonInstallHelper::installFOF($parent);
		}

		$this->_renderPostInstallation($status, $parent);
	}

	/**
	 * Renders the post-installation message
	 *
	 * @param   JObject     $status  Status of the installed subextensions
	 * @param   JInstaller  $parent  Parent object
	 *
	 * @return void
	 */
	private function _renderPostInstallation($status, $parent)
	{
?>

<?php $rows = 1;?>
<h2>Installation Results</h2>

<table class="adminlist table table-striped" width="100%">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2">Babioon Event component</td>
			<td><strong style="color: green">Installed</strong></td>
		</tr>

		<?php if (!empty($status->fof)) : ?>
			<tr class="row<?php echo ($rows++ % 2); ?>">
				<td class="key" colspan="2">FOF</td>
				<?php if ($status->fof['required']) : ?>
					<?php if ($status->fof['installed']) : ?>
						<td><strong style="color: green">Installed</strong> - Version: <?php echo $status->fof['version'] . '(' . $status->fof['date'] .')' ; ?></td>
					<?php else : ?>
						<td><strong style="color: red">NOT Installed</strong></td>
					<?php endif; ?>
				<?php else : ?>
					<td><strong style="color: green">Installation not necessary</strong></td>
				<?php endif; ?>
			</tr>
		<?php endif; ?>

		<?php if (count($status->subextensions->modules)) : ?>
		<tr>
			<th>Module</th>
			<th>Client</th>
			<th></th>
		</tr>
		<?php foreach ($status->subextensions->modules as $module) : ?>
		<tr class="row<?php echo ($rows++ % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong style="color: <?php echo ($module['result'])? "green" : "red"?>"><?php echo ($module['result'])?'Installed':'Not installed'; ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<?php if (count($status->subextensions->plugins)) : ?>
		<tr>
			<th>Plugin</th>
			<th>Group</th>
			<th></th>
		</tr>
		<?php foreach ($status->subextensions->plugins as $plugin) : ?>
		<tr class="row<?php echo ($rows++ % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong style="color: <?php echo ($plugin['result'])? "green" : "red"?>"><?php echo ($plugin['result'])?'Installed':'Not installed'; ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

<?php
	}

	private function _renderPostUninstallation($status, $parent)
	{
?>
<?php $rows = 0;?>
<h2>Uninstallation Results</h2>
<table class="adminlist table table-striped" width="100%">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'Babioon Event '.JText::_('Component'); ?></td>
			<td><strong style="color: green"><?php echo JText::_('Removed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong style="color: <?php echo ($module['result'])? "green" : "red"?>"><?php echo ($module['result'])?JText::_('Removed'):JText::_('Not removed'); ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<?php if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong style="color: <?php echo ($plugin['result'])? "green" : "red"?>"><?php echo ($plugin['result'])?JText::_('Removed'):JText::_('Not removed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<?php
	}

}
