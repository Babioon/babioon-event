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
$comp = 'com_babioonevent';

if (!$user->authorise('core.manage', $comp) && !$user->authorise('core.admin', $comp))
{
	$app = JFactory::getApplication();
	$app->redirect('index.php', JText::_('JERROR_ALERTNOAUTHOR'), 'error');
}

if (!defined('BABIOON'))
{
	// We need the BABIOON System Plugin
	jexit('we need the BABIOON System Plugin');
}

require JPATH_COMPONENT . '/helpers/babioonevent.php';

// START: Akeeba Live Update
$view = JFactory::getApplication()->input->get('view', 'default');

// Load files if needed
if ($view == 'liveupdate' || $view == 'default')
{
	if (file_exists(JPATH_COMPONENT . '/liveupdate/liveupdate.php'))
	{
		require_once JPATH_COMPONENT . '/liveupdate/liveupdate.php';
	}
	else
	{
		return JError::raiseWarning(404, JText::_(strtoupper($comp) . '_COULD_NOT_LOAD_LIVEUPDATE_FILES'));
	}
}

if ($view == 'liveupdate')
{
	if (JFactory::getUser()->authorise('core.admin', $comp))
	{
		LiveUpdate::handleRequest();

		return;
	}
	else
	{
		return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	}
}

// END: Akeeba Live Update

// Execute the task.
$controller	= JControllerLegacy::getInstance('BabioonEvent');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

/** EOF **/