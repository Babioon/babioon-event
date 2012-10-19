<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of com_rde_admin component
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
        
		
		try {
    		// update check
    		$query=$db->getQuery(true);
    		/**
    		 * update will only work when old db prefix is jos
    		 */
    		$query->select('*')
    		    ->from('jos_categories')
    		    ->where('section  = "com_rd_event_data"')
    		    ->orderby('ordering');
    		    
    	    $db->setQuery($query);
    	    $oldcat=$db->loadObjectList();

			$root	= JTable::getInstance('category');
			$root->load(1);

			$comp	= JTable::getInstance('asset');
			$comp->loadByName('com_babioonevent');
			foreach($oldcat AS $c)
            {
                $id=$c->id;
                
                $newcat	= JTable::getInstance('category');
                $newcat->title     = $c->title;
                $newcat->alias     = $c->alias;
                $newcat->path      = $c->alias;
                $newcat->published = 1;
                $newcat->params    = "{}";
                $newcat->language  = "*";
                $newcat->set('_trackAssets', false);
                $newcat->extension = 'com_babioonevent';
    			$newcat->setLocation($root->id, 'last-child');
    			if (!$newcat->check() || !$newcat->store()) {
    				//$this->setError($newcat->getError());
    				return false;
    			}
    			$asset	= JTable::getInstance('asset');
			    $asset->name = 'com_babioonevent.category.'.$id;
		    	$asset->title = $c->title;
    			$asset->setLocation($comp->id, 'last-child');
    			if (!$asset->check() || !$asset->store()) {
    				//$this->setError($asset->getError());
    				return false;
    			}
    			
                $query->clear();
                $query->update('#__categories')
                    ->set('id='.$id)
                    ->set('asset_id='.$asset->id)
                    ->where('id='.$newcat->id);    
    			$db->setQuery($query);
    			$db->query();
    			
    			
            }    	    
		} catch (Exception $e) {
		    // whatever happen ignore it
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
