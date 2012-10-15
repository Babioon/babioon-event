<?php
/**
 * babioon events
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENTS
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__).'/../objects.html.php';

/**
 * BabioonKoorgaViewServices
 */
class BabioonEventViewEvents extends BabioonEventViewObjects
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