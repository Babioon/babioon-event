<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;


/**
 * BabioonEventHelper
 *
 * @package		BABIOON_EVENT
 */
class BabioonEventHelper
{

	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected static $text_prefix = 'COM_BABIOONEVENT_';
    
    
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($vName)
	{
		$submenu = array('default','events');
	    foreach($submenu AS $item)
	    {
    	    JSubMenuHelper::addEntry(
    			JText::_(self::$text_prefix.strtoupper($item)),
    			'index.php?option=com_babioonevent&view='.$item,
    			$vName == $item
    		);
	    }
		JSubMenuHelper::addEntry(
			JText::_('COM_BABIOONEVENT_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_babioonevent',
			$vName == 'categories'
		);
		
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_babioonevent')),
				'babioonevent-categories');
		}
	    
	}
    
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	
	 *
	 * @return	JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		$assetName = 'com_babioonevent';
		
		$actions = array(
			'babioonevent.admin', 'babioonevent.manage', 'babioonevent.create', 'babioonevent.edit', 'babioonevent.edit.state', 'babioonevent.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	
	public static function toSigular($plural)
	{
	    $sigular='';
	    switch($plural)
	    {
	        case 'events'        : $sigular='event';         break;
	    }
	    return $sigular;
	} 
	
		
	
	
}