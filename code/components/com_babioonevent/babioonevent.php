<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

if (!defined('BABIOON'))
{
	// We need the BABIOON System Plugin
	jexit('we need the BABIOON System Plugin');
}

// Include dependancies
jimport('joomla.application.component.controller');

require JPATH_COMPONENT . '/helpers/route.php';

// Execute the task.
$controller	= JController::getInstance('BabioonEvent');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

/** EOF **/