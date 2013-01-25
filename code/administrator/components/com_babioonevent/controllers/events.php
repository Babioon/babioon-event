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

jimport('joomla.application.component.controlleradmin');

/**
 * BabioonEvent Event controller class.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventControllerEvents extends JControllerAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_BABIOONEVENT_';

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    Model name
	 * @param   string  $prefix  Prefix
	 * @param   array   $config  configuration array
	 *
	 * @return  the model
	 */
	public function getModel($name = 'Event', $prefix = 'BabioonEventModel', $config = array('ignore_request' => true))
	{
		// Note: Name in singular
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}
