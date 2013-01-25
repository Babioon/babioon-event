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

// Access check.
$user = JFactory::getUser();

if (!$user->authorise('core.manage', 'com_babioonevent') && !$user->authorise('core.admin', 'com_babioonevent'))
{
	$app = JFactory::getApplication();
	$app->redirect('index.php', JText::_('JERROR_ALERTNOAUTHOR'), 'error');
}

if (!defined('BABIOON'))
{
	// We need the BABIOON System Plugin
	jexit('we need the BABIOON System Plugin');
}

// Include dependancies
jimport('joomla.application.component.controller');

require JPATH_COMPONENT . '/helpers/babioonevent.php';

// Execute the task.
$controller	= JController::getInstance('BabioonEvent');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

/** EOF **/