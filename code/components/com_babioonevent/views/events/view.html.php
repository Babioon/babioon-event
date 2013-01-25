<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die ('Restricted access');

require_once dirname(__FILE__) . '/../objects.html.php';

/**
 * BabioonEventViewEvents
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewEvents extends BabioonEventViewObjects
{
	/**
	 * Default view, list of items
	 *
	 * @param   string  $tpl  used template
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Default is to show the events
		$this->assignRef('element', $this->get('Item'));
		parent::display($tpl);
	}
}
