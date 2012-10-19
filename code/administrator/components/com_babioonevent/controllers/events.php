<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * BabioonEvent Event controller class.
 *
 * @package BABIOON_EVENT
 */
class BabioonEventControllerEvents extends JControllerAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_BABIOONEVENT_';

	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/babioonevent.php';
		
		// Load the submenu.
		// Note: use plural
		BabioonEventHelper::addSubmenu( 'events' );
		
		parent::display();

		return $this;
	}
	
	/**
	 * Proxy for getModel.
	 */
	public function getModel($name = 'Event', $prefix = 'BabioonEventModel', $config = array('ignore_request' => true))
	{
		// Note: Name in singular
	    $model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	
}	