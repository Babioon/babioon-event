<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// Try to load router helper
if(!class_exists('BabioonEventRouteHelper'))
{
	if(file_exists(JPATH_SITE.'/components/com_babioonevent/helpers/route.php'))
	{
		require_once JPATH_SITE.'/components/com_babioonevent/helpers/route.php';	
	}	
}	
if(!class_exists('BabioonEventRouteHelper', false))
{
	// We gave our best 
	echo JText::_('MOD_BABIONEVENT_ROUTEHELPER_NOT_AVAILABLE');
	return false;
}	
else
{
	// Include the helper functions only once
	require_once dirname(__FILE__).'/helper.php';
	$items=modBabiooneventEventlistHelper::getItems($params);
	require JModuleHelper::getLayoutPath('mod_babioonevent_eventlist', $params->get('layout', 'default'));
}	
