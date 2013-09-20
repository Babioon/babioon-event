<?php

// No direct access
defined('_JEXEC') or die;

/* Directory relative to the admin dir where your installation sql are saved */
define('BABIOON_INSTALL_SUBDIR', 'install/sql/');

/**
 * Install Helper
 *
 * @package  BABIOON
 * @since    2.0.0
 */
class BabioonInstallHelper
{

	/**
	 * get a variable from the manifest file (actually, from the manifest cache).
	 *
	 * CODE COPIED FROM doc.joomla.org
	 *
	 * @param   string  $name       name of the param
	 * @param   string  $component  name of the component
	 *
	 * @return string
	 */
	public static function getParam($name, $component)
	{
		$result = '';
		$db     = JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('manifest_cache')
				->from('#__extensions')
				->where('name = "' . $component . '"');
		$db->setQuery($query);
		$manifest = json_decode($db->loadResult(), true);

		if (array_key_exists($name, $manifest))
		{
			$result = $manifest[$name];
		}

		return $result;
	}

	/**
	 * FOLLOWING CODE IS A MORE OR LESS A PLAIN COPY FROM PARTS OF THE INSTALLATION SCRIPT
	 * OF THE GREAT AKKEBA BACKUP COMPONENT ALL WHAT I DID WAS TO EXTRACT IT, COPY IT IN
	 * SEPERATE FILE AND SOME MINOR CHANGES
	 *
	 * THANKS TO Nicholas, you saved some hours of my lifetime :-) I can now waste
	 * with other things :-)
	 *
	 * @copyright Copyright (c)2009-2013 Nicholas K. Dionysopoulos
	 * @license GNU General Public License version 3, or later
	 */

	/**
	 * Installs subextensions (modules, plugins) bundled with the main extension
	 *
	 * @param   JInstaller  $parent              Installer object
	 * @param   array       $installation_queue  Array of subextensions to install
	 *
	 * @return JObject The subextension installation status
	 */
	public static function installSubextensions($parent, $installation_queue)
	{
		$src = $parent->getParent()->getPath('source');

		$db = JFactory::getDbo();

		$status = new JObject;
		$status->modules = array();
		$status->plugins = array();

		// Modules installation
		if (count($installation_queue['modules']))
		{
			foreach ($installation_queue['modules'] as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Install the module
						if (empty($folder))
						{
							$folder = 'site';
						}
						$path = "$src/modules/$folder/$module";

						if (!is_dir($path))
						{
							$path = "$src/modules/$folder/mod_$module";
						}

						if (!is_dir($path))
						{
							$path = "$src/modules/$module";
						}

						if (!is_dir($path))
						{
							$path = "$src/modules/mod_$module";
						}

						if (!is_dir($path))
						{
							continue;
						}

						// Was the module already installed?
						$sql = $db->getQuery(true)
							->select('COUNT(*)')
							->from('#__modules')
							->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));
						$db->setQuery($sql);
						$count = $db->loadResult();
						$installer = new JInstaller;
						$result = $installer->install($path);
						$status->modules[] = array(
							'name'   => 'mod_' . $module,
							'client' => $folder,
							'result' => $result
						);

						// Modify where it's published and its published state
						if (!$count)
						{
							// A. Position and state
							list($modulePosition, $modulePublished) = $modulePreferences;

							if ($modulePosition == 'cpanel')
							{
								$modulePosition = 'icon';
							}
							$sql = $db->getQuery(true)
								->update($db->qn('#__modules'))
								->set($db->qn('position') . ' = ' . $db->q($modulePosition))
								->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));

							if ($modulePublished)
							{
								$sql->set($db->qn('published') . ' = ' . $db->q('1'));
							}
							$db->setQuery($sql);
							$db->execute();

							// B. Change the ordering of back-end modules to 1 + max ordering
							if ($folder == 'admin')
							{
								$query = $db->getQuery(true);
								$query->select('MAX(' . $db->qn('ordering') . ')')
									->from($db->qn('#__modules'))
									->where($db->qn('position') . '=' . $db->q($modulePosition));
								$db->setQuery($query);
								$position = $db->loadResult();
								$position++;

								$query = $db->getQuery(true);
								$query->update($db->qn('#__modules'))
									->set($db->qn('ordering') . ' = ' . $db->q($position))
									->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));
								$db->setQuery($query);
								$db->execute();
							}

							// C. Link to all pages
							$query = $db->getQuery(true);
							$query->select('id')->from($db->qn('#__modules'))
								->where($db->qn('module') . ' = ' . $db->q('mod_' . $module));
							$db->setQuery($query);
							$moduleid = $db->loadResult();

							$query = $db->getQuery(true);
							$query->select('*')->from($db->qn('#__modules_menu'))
								->where($db->qn('moduleid') . '  = ' . $db->q($moduleid));
							$db->setQuery($query);
							$assignments = $db->loadObjectList();
							$isAssigned = !empty($assignments);

							if (!$isAssigned)
							{
								$o = (object) array(
									'moduleid'	=> $moduleid,
									'menuid'	=> 0
								);
								$db->insertObject('#__modules_menu', $o);
							}
						}
					}
				}
			}
		}

		// Plugins installation
		if (count($installation_queue['plugins']))
		{
			foreach ($installation_queue['plugins'] as $folder => $plugins)
			{
				if (count($plugins))
				{
					foreach ($plugins as $plugin => $published)
					{
						$path = "$src/plugins/$folder/$plugin";

						if (!is_dir($path))
						{
							$path = "$src/plugins/$folder/plg_$plugin";
						}
						if (!is_dir($path))
						{
							$path = "$src/plugins/$plugin";
						}
						if (!is_dir($path))
						{
							$path = "$src/plugins/plg_$plugin";
						}
						if (!is_dir($path))
						{
							continue;
						}

						// Was the plugin already installed?
						$query = $db->getQuery(true)
							->select('COUNT(*)')
							->from($db->qn('#__extensions'))
							->where($db->qn('element') . ' = ' . $db->q($plugin))
							->where($db->qn('folder') . ' = ' . $db->q($folder));
						$db->setQuery($query);
						$count = $db->loadResult();

						$installer = new JInstaller;
						$result = $installer->install($path);

						$status->plugins[] = array('name' => 'plg_' . $plugin, 'group' => $folder, 'result' => $result);

						if ($published && !$count)
						{
							$query = $db->getQuery(true)
								->update($db->qn('#__extensions'))
								->set($db->qn('enabled') . ' = ' . $db->q('1'))
								->where($db->qn('element') . ' = ' . $db->q($plugin))
								->where($db->qn('folder') . ' = ' . $db->q($folder));
							$db->setQuery($query);
							$db->execute();
						}
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Uninstalls subextensions (modules, plugins) bundled with the main extension
	 *
	 * @param   JInstaller  $parent              Installer object
	 * @param   array       $installation_queue  Array of subextensions to install
	 *
	 * @return JObject The subextension installation status
	 */
	public static function uninstallSubextensions($parent, $installation_queue)
	{
		JLoader::import('joomla.installer.installer');

		$db = & JFactory::getDBO();

		$status = new JObject;
		$status->modules = array();
		$status->plugins = array();

		$src = $parent->getParent()->getPath('source');

		// Modules uninstallation
		if (count($installation_queue['modules']))
		{
			foreach ($installation_queue['modules'] as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Find the module ID
						$sql = $db->getQuery(true)
							->select($db->qn('extension_id'))
							->from($db->qn('#__extensions'))
							->where($db->qn('element') . ' = ' . $db->q('mod_' . $module))
							->where($db->qn('type') . ' = ' . $db->q('module'));
						$db->setQuery($sql);
						$id = $db->loadResult();

						// Uninstall the module
						if ($id)
						{
							$installer = new JInstaller;
							$result = $installer->uninstall('module', $id, 1);
							$status->modules[] = array(
								'name'   => 'mod_' . $module,
								'client' => $folder,
								'result' => $result
							);
						}
					}
				}
			}
		}

		// Plugins uninstallation
		if (count($installation_queue['plugins']))
		{
			foreach ($installation_queue['plugins'] as $folder => $plugins)
			{
				if (count($plugins))
				{
					foreach ($plugins as $plugin => $published)
					{
						$sql = $db->getQuery(true)
							->select($db->qn('extension_id'))
							->from($db->qn('#__extensions'))
							->where($db->qn('type') . ' = ' . $db->q('plugin'))
							->where($db->qn('element') . ' = ' . $db->q($plugin))
							->where($db->qn('folder') . ' = ' . $db->q($folder));
						$db->setQuery($sql);

						$id = $db->loadResult();

						if ($id)
						{
							$installer = new JInstaller;
							$result = $installer->uninstall('plugin', $id, 1);
							$status->plugins[] = array(
								'name'   => 'plg_' . $plugin,
								'group'  => $folder,
								'result' => $result
							);
						}
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Joomla! 1.6+ bugfix for "DB function returned no error"
	 *
	 * @param   string  $extension  Extension name
	 *
	 * @return void
	 */
	public static function bugfixDBFunctionReturnedNoError($extension)
	{
		$db = JFactory::getDbo();

		// Fix broken #__assets records
		$query = $db->getQuery(true);
		$query->select('id')
			->from('#__assets')
			->where($db->qn('name') . ' = ' . $db->q($extension));
		$db->setQuery($query);
		$ids = $db->loadColumn();

		if (!empty($ids))
		{
			foreach ($ids as $id)
			{
				$query = $db->getQuery(true);
				$query->delete('#__assets')
					->where($db->qn('id') . ' = ' . $db->q($id));
				$db->setQuery($query);
				$db->execute();
			}
		}

		// Fix broken #__extensions records
		$query = $db->getQuery(true);
		$query->select('extension_id')
			->from('#__extensions')
			->where($db->qn('element') . ' = ' . $db->q($extension));
		$db->setQuery($query);
		$ids = $db->loadColumn();

		if (!empty($ids))
		{
			foreach ($ids as $id)
			{
				$query = $db->getQuery(true);
				$query->delete('#__extensions')
					->where($db->qn('extension_id') . ' = ' . $db->q($id));
				$db->setQuery($query);
				$db->execute();
			}
		}

		// Fix broken #__menu records
		$query = $db->getQuery(true);
		$query->select('id')
			->from('#__menu')
			->where($db->qn('type') . ' = ' . $db->q('component'))
			->where($db->qn('menutype') . ' = ' . $db->q('main'))
			->where($db->qn('link') . ' LIKE ' . $db->q('index.php?option=' . $extension));
		$db->setQuery($query);
		$ids = $db->loadColumn();

		if (!empty($ids))
		{
			foreach ($ids as $id)
			{
				$query = $db->getQuery(true);
				$query->delete('#__menu')
					->where($db->qn('id') . ' = ' . $db->q($id));
				$db->setQuery($query);
				$db->execute();
			}
		}
	}

	/**
	 * Joomla! 1.6+ bugfix for "Can not build admin menus"
	 *
	 * @param   string  $extension  Extension name
	 *
	 * @return void
	 */
	public static function bugfixCantBuildAdminMenus($extension)
	{
		$db = JFactory::getDbo();

		// If there are multiple #__extensions record, keep one of them
		$query = $db->getQuery(true);
		$query->select('extension_id')
			->from('#__extensions')
			->where($db->qn('element') . ' = ' . $db->q($extension));
		$db->setQuery($query);
		$ids = $db->loadColumn();

		if (count($ids) > 1)
		{
			asort($ids);

			// Keep the oldest id
			$extension_id = array_shift($ids);

			foreach ($ids as $id)
			{
				$query = $db->getQuery(true);
				$query->delete('#__extensions')
					->where($db->qn('extension_id') . ' = ' . $db->q($id));
				$db->setQuery($query);
				$db->execute();
			}
		}

		// If there are multiple assets records, delete all except the oldest one
		$query = $db->getQuery(true);
		$query->select('id')
			->from('#__assets')
			->where($db->qn('name') . ' = ' . $db->q($extension));
		$db->setQuery($query);
		$ids = $db->loadObjectList();

		if (count($ids) > 1)
		{
			asort($ids);

			// Keep the oldest id
			$asset_id = array_shift($ids);

			foreach ($ids as $id)
			{
				$query = $db->getQuery(true);
				$query->delete('#__assets')
					->where($db->qn('id') . ' = ' . $db->q($id));
				$db->setQuery($query);
				$db->execute();
			}
		}

		// Remove #__menu records for good measure!
		$query = $db->getQuery(true);
		$query->select('id')
			->from('#__menu')
			->where($db->qn('type') . ' = ' . $db->q('component'))
			->where($db->qn('menutype') . ' = ' . $db->q('main'))
			->where($db->qn('link') . ' LIKE ' . $db->q('index.php?option=' . $extension));
		$db->setQuery($query);
		$ids1 = $db->loadColumn();

		if (empty($ids1))
		{
			$ids1 = array();
		}
		$query = $db->getQuery(true);
		$query->select('id')
			->from('#__menu')
			->where($db->qn('type') . ' = ' . $db->q('component'))
			->where($db->qn('menutype') . ' = ' . $db->q('main'))
			->where($db->qn('link') . ' LIKE ' . $db->q('index.php?option=' . $extension . '&%'));
		$db->setQuery($query);
		$ids2 = $db->loadColumn();

		if (empty($ids2))
		{
			$ids2 = array();
		}
		$ids = array_merge($ids1, $ids2);

		if (!empty($ids))
		{
			foreach ($ids as $id)
			{
				$query = $db->getQuery(true);
				$query->delete('#__menu')
					->where($db->qn('id') . ' = ' . $db->q($id));
				$db->setQuery($query);
				$db->execute();
			}
		}
	}

	/**
	 * When you are upgrading from an old version of the component or when your
	 * site is upgraded from Joomla! 1.5 there is no "schema version" for our
	 * component's tables. As a result Joomla! doesn't run the database queries
	 * and you get a broken installation.
	 *
	 * This method detects this situation, forces a fake schema version "0.0.1"
	 * and lets the crufty mess Joomla!'s extensions installer is to bloody work
	 * as anyone would have expected it to do!
	 *
	 * @param   string  $extension  Extension name
	 *
	 * @return void
	 */
	public static function fixSchemaVersion($extension)
	{
		// Get the extension ID
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('extension_id')
			->from('#__extensions')
			->where($db->qn('element') . ' = ' . $db->q($extension));
		$db->setQuery($query);
		$eid = $db->loadResult();

		$query = $db->getQuery(true);
		$query->select('version_id')
			->from('#__schemas')
			->where('extension_id = ' . $eid);
		$db->setQuery($query);
		$version = $db->loadResult();

		if (!$version)
		{
			// No schema version found. Fix it.
			$o = (object) array(
				'version_id'	=> '2.0.0',
				'extension_id'	=> $eid,
			);
			$db->insertObject('#__schemas', $o);
		}
	}

	/**
	 * Let's say that a user tries to install a component and it somehow fails
	 * in a non-graceful manner, e.g. a server timeout error, going over the
	 * quota etc. In this case the component's administrator directory is
	 * created and not removed (because the installer died an untimely death).
	 * When the user retries installing the component JInstaller sees that and
	 * thinks it's an update. This causes it to neither run the installation SQL
	 * file (because it's not supposed to run on extension update) nor the
	 * update files (because there is no schema version defined). As a result
	 * the files are installed, the database tables are not, the component is
	 * broken and I have to explain to non-technical users how to edit their
	 * database with phpMyAdmin.
	 *
	 * This method detects this stupid situation and attempts to execute the
	 * installation file instead.
	 *
	 * @param   string      $extension  Extension name
	 * @param   JInstaller  $parent     Installer object
	 *
	 * @return void
	 */
	public static function fixBrokenSQLUpdates($extension, $parent)
	{
		// Get the extension ID
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('extension_id')
			->from('#__extensions')
			->where($db->qn('element') . ' = ' . $db->q($extension));
		$db->setQuery($query);
		$eid = $db->loadResult();

		// Get the schema version
		$query = $db->getQuery(true);
		$query->select('version_id')
			->from('#__schemas')
			->where('extension_id = ' . $eid);
		$db->setQuery($query);
		$version = $db->loadResult();

		// If there is a schema version it's not a false update
		if ($version)
		{
			return;
		}

		// Execute the installation SQL file. Since I don't have access to
		// the manifest, I will improvise (again!)
		$dbDriver = strtolower($db->name);

		if ($dbDriver == 'mysqli')
		{
			$dbDriver = 'mysql';
		}
		elseif($dbDriver == 'sqlsrv')
		{
			$dbDriver = 'sqlazure';
		}

		// Get the name of the sql file to process
		$sqlfile = $parent->getParent()->getPath('extension_root') . '/' . BABIOON_INSTALL_SUBDIR . $dbDriver . '/install.sql';

		if (file_exists($sqlfile))
		{
			$buffer = file_get_contents($sqlfile);

			if ($buffer === false)
			{
				return;
			}

			$queries = JInstallerHelper::splitSql($buffer);

			if (count($queries) == 0)
			{
				// No queries to process
				return;
			}

			// Process each query in the $queries array (split out of sql file).
			foreach ($queries as $query)
			{
				$query = trim($query);

				if ($query != '' && $query{0} != '#')
				{
					$db->setQuery($query);

					if (!$db->execute())
					{
						JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));

						return false;
					}
				}
			}
		}

		// Update #__schemas to the latest version. Again, since I don't have
		// access to the manifest I have to improvise...
		$path = $parent->getParent()->getPath('extension_root') . '/' . BABIOON_INSTALL_SUBDIR . 'updates/' . $dbDriver;
		$files = str_replace('.sql', '', JFolder::files($path, '\.sql$'));

		if (count($files) > 0)
		{
			usort($files, 'version_compare');
			$version = array_pop($files);
		}
		else
		{
			$version = '0.0.1-2007-08-15';
		}

		$query = $db->getQuery(true);
		$query->insert($db->quoteName('#__schemas'));
		$query->columns(array($db->quoteName('extension_id'), $db->quoteName('version_id')));
		$query->values($eid . ', ' . $db->quote($version));
		$db->setQuery($query);
		$db->execute();
	}

	/**
	 * Check if FoF is already installed and install if not
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  array            Array with performed actions summary
	 */
	public static function installFOF($parent)
	{
		$src = $parent->getParent()->getPath('source');

		// Load dependencies
		JLoader::import('joomla.filesystem.file');
		JLoader::import('joomla.utilities.date');
		$source = $src . '/fof';

		if (!defined('JPATH_LIBRARIES'))
		{
			$target = JPATH_ROOT . '/libraries/fof';
		}
		else
		{
			$target = JPATH_LIBRARIES . '/fof';
		}

		$haveToInstallFOF = false;

		if (!is_dir($target))
		{
			$haveToInstallFOF = true;
		}
		else
		{
			$fofVersion = array();

			if (file_exists($target . '/version.txt'))
			{
				$rawData = JFile::read($target . '/version.txt');
				$info    = explode("\n", $rawData);
				$fofVersion['installed'] = array(
					'version'   => trim($info[0]),
					'date'      => new JDate(trim($info[1]))
				);
			}
			else
			{
				$fofVersion['installed'] = array(
					'version'   => '0.0',
					'date'      => new JDate('2011-01-01')
				);
			}

			$rawData = JFile::read($source . '/version.txt');
			$info    = explode("\n", $rawData);
			$fofVersion['package'] = array(
				'version'   => trim($info[0]),
				'date'      => new JDate(trim($info[1]))
			);

			$haveToInstallFOF = $fofVersion['package']['date']->toUNIX() > $fofVersion['installed']['date']->toUNIX();
		}

		$installedFOF = false;

		if ($haveToInstallFOF)
		{
			$versionSource = 'package';
			$installer = new JInstaller;
			$installedFOF = $installer->install($source);
		}
		else
		{
			$versionSource = 'installed';
		}

		if (!isset($fofVersion))
		{
			$fofVersion = array();

			if (file_exists($target . '/version.txt'))
			{
				$rawData = JFile::read($target . '/version.txt');
				$info    = explode("\n", $rawData);
				$fofVersion['installed'] = array(
					'version'   => trim($info[0]),
					'date'      => new JDate(trim($info[1]))
				);
			}
			else
			{
				$fofVersion['installed'] = array(
					'version'   => '0.0',
					'date'      => new JDate('2011-01-01')
				);
			}

			$rawData = JFile::read($source . '/version.txt');
			$info    = explode("\n", $rawData);
			$fofVersion['package'] = array(
				'version'   => trim($info[0]),
				'date'      => new JDate(trim($info[1]))
			);
			$versionSource = 'installed';
		}

		if (!($fofVersion[$versionSource]['date'] instanceof JDate))
		{
			$fofVersion[$versionSource]['date'] = new JDate;
		}

		return array(
			'required'  => $haveToInstallFOF,
			'installed' => $installedFOF,
			'version'   => $fofVersion[$versionSource]['version'],
			'date'      => $fofVersion[$versionSource]['date']->format('Y-m-d'),
		);
	}
}
