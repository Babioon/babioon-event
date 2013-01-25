<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access.
defined('_JEXEC') or die;

/**
 * Event table
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventTableEvent extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__babioonevent_events', 'id', $db);
	}
}
