<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__).'/../object.html.php';

/**
 * BabioonEventViewEvent
 */
class BabioonEventViewEvent extends BabioonEventViewObject
{
	/**
	 * Default view, list of items
	 * 
	 * @param string $tpl
	 */
    function display($tpl = null)
	{
		parent::display($tpl);
	}
    
}