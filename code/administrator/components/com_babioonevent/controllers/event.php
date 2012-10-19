<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

require_once JPATH_COMPONENT.'/helpers/babioonevent.php';

/**
 * Babioon Event Events controller class.
 *
 * @package BABIOON_EVENT
 */
class BabioonEventControllerEvent extends JControllerForm
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_BABIOONEVENT_';

	
}	