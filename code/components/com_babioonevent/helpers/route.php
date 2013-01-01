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
 * BabioonEventRouteHelper
 */
class BabioonEventRouteHelper
{

    public static function getItemid($type="default")
    {
        $result=null;
        $app=JFactory::getApplication();
        
        switch ($type)
        {
            case "events":
                $result = $app->getMenu()
                                ->getItems('link','index.php?option=com_babioonevent&view=events', true );
                break;
        }
        
        $result = is_object($result) ? $result->id : $app->input->get('Itemid', 0, 'uint');      
        return $result;
    }  
}
