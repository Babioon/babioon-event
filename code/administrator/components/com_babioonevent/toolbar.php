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
	 * change the toolbar so that a copy button is available
	 *
	 * @return void
	 */
	public function onEventsBrowse()
	{
		// Render the submenu
		$this->renderSubmenu();

		// Set toolbar title
		$option = $this->input->getCmd('option', 'com_foobar');
		$subtitle_key = strtoupper($option . '_TITLE_' . $this->input->getCmd('view', 'cpanel'));
		JToolBarHelper::title(JText::_(strtoupper($option)) . ': ' . JText::_($subtitle_key), str_replace('com_', '', $option));

		// Add toolbar buttons
		if ($this->perms->create)
		{
			JToolBarHelper::addNew();
		}

		if ($this->perms->edit)
		{
			JToolBarHelper::editList();
			JToolBarHelper::custom('copy', 'copy.png', 'copy_f2.png', 'JLIB_HTML_BATCH_COPY', false);
		}

		if ($this->perms->create || $this->perms->edit)
		{
			JToolBarHelper::divider();
		}

		if ($this->perms->editstate)
		{
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::divider();
		}

		if ($this->perms->delete)
		{
			$msg = JText::_($this->input->getCmd('option', 'com_foobar') . '_CONFIRM_DELETE');
			JToolBarHelper::deleteList(strtoupper($msg));
		}
	}

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
