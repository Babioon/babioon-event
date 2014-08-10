<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * class BabioonEventToolbar
 *
 * @package  BABIOON_EVENT
 * @since    3.0
 */
class BabioonEventToolbar extends FOFToolbar
{
	/**
	 * Renders the submenu (toolbar links) for all detected views of this component
	 *
	 * @return  void
	 */
	public function renderSubmenu()
	{
		parent::renderSubmenu();

		$activeView = $this->input->getCmd('extension', '');
		$this->appendLink(JText::_('COM_BABIOONEVENT_CATEGORIES'), 'index.php?option=com_categories&extension=com_babioonevent', 'com_babioonevent' == $activeView);

		$activeView = $this->input->getCmd('view', 'cpanel');
		$this->appendLink(JText::_('COM_BABIOONEVENT_LIVEUPDATE'), 'index.php?option=com_babioonevent&view=liveupdate', 'liveupdate' == $activeView);
	}
}
