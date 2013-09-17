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

// Load FOF
include_once JPATH_LIBRARIES . '/fof/include.php';

if (!defined('FOF_INCLUDED'))
{
	JError::raiseError('500', 'FOF is not installed');
}

require_once JPATH_COMPONENT . '/helpers/babioonevent.php';

// Access check.
$user = JFactory::getUser();
$comp = 'com_babioonevent';

// START: Akeeba Live Update
$view = JFactory::getApplication()->input->get('view', 'cpanels');

// Load files if needed
if ($view == 'liveupdate' || $view == 'cpanels')
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



FOFDispatcher::getTmpInstance('com_babioonevent')->dispatch();

/** EOF **/