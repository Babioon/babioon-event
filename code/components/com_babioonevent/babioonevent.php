<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Load FOF
require_once JPATH_LIBRARIES . '/fof/include.php';

if (!defined('FOF_INCLUDED'))
{
	JError::raiseError('500', 'FOF is not installed');
}

require_once dirname(__FILE__) . '/helpers/route.php';
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/babioonevent.php';

FOFDispatcher::getTmpInstance('com_babioonevent')->dispatch();

/** EOF **/