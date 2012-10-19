<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access.
defined('_JEXEC') or die;

/**
 * Event table
 */
class BabioonEventTableEvent extends JTable
{
	/**
	 * Constructor
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__babioonevent_events', 'id', $_db);
	}
	

}
