<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;

/**
 * BabioonEventViewEvents
 *
 * @package  BABIOON_EVENT
 * @since    3.0
 */
class BabioonEventViewEvents extends FOFViewHtml
{

	public function onEresult()
	{
		$this->files = $this->getModel()->getExportFile();
	}
}
