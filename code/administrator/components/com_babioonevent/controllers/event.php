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

jimport('joomla.application.component.controllerform');

require_once JPATH_COMPONENT . '/helpers/babioonevent.php';

/**
 * Babioon Event Events controller class.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventControllerEvent extends JControllerForm
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_BABIOONEVENT_';
}
