<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of com_babioonevent component
 */
class com_babiooneventInstallerScript
{
	
    function databaseMagicOnInstall()
    {
        $db=JFactory::getDbo();
        // we need to add some asset rows on install, this is a tree
		$asset	= JTable::getInstance('asset');
		if (!$asset->loadByName('com_babioonevent')) 
		{
			$root	= JTable::getInstance('asset');
			$root->loadByName('root.1');
			$asset->name = 'com_babioonevent';
			$asset->title = 'com_babioonevent';
			$asset->setLocation($root->id, 'last-child');
			if (!$asset->check() || !$asset->store()) {
				//$this->setError($asset->getError());
				return false;
			}
		}
		return true;
    }
	
	
	
	
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_babioonevent');
        self::databaseMagicOnInstall();
	}

	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function discover_install($parent) 
	{
        self::install($parent);
	}
	
	
	
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{

		echo '<p>' . JText::_('COM_BABIOONEVENT_UNINSTALL_TEXT') . '</p>';
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::sprintf('COM_BABIOONEVENT_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_BABIOONEVENT_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_BABIOONEVENT_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}
