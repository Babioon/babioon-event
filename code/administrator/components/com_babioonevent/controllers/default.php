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

require_once JPATH_COMPONENT.'/helpers/helpers.php';

/**
 * Babioon Event Default controller class.
 *
 * @package BABIOON_KOORGA
 */
class BabioonEventControllerDefault extends JControllerAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_BABIOONEVENT_';

	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/helpers.php';
		
		// Load the submenu.
		BabioonKoorgaHelpers::addSubmenu( 'default' );
		
		parent::display();

		return $this;
	}
	
	
}	