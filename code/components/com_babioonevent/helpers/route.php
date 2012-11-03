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
        /*
        switch ($type)
        {
            
        }
        */
        $result = is_object($result) ? $result->id : $app->input->get('Itemid', 0, 'uint');      
        return $result;
    }  
}
