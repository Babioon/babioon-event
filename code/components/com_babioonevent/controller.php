<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Babioon Event Component Controller
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventController extends JController
{

	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types,for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;
		$app      = JFactory::getApplication();
		$view     = $app->input->get('view', 'events');
		$app->input->set('view', $view);

		$safeurlparams = array('catid' => 'INT', 'id' => 'INT', 'cid' => 'ARRAY', 'year' => 'INT', 'month' => 'INT', 'limit' => 'INT', 'limitstart' => 'INT',
			'showall' => 'INT', 'return' => 'BASE64', 'filter' => 'STRING', 'filter_order' => 'CMD', 'filter_order_Dir' => 'CMD', 'filter-search' => 'STRING', 'print' => 'BOOLEAN', 'lang' => 'CMD');

		parent::display($cachable, $safeurlparams);

		return $this;
	}
}
