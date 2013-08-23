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

jimport('joomla.application.component.view');

/**
 * class BabioonEventViewDefault
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewDefault extends JViewLegacy
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
		if (BabioonEventHelper::isVersion3())
		{
			$name     = $this->getName();
			$this->addTemplatePath(dirname(__FILE__) . '/tmpl3');
			$this->sidebar = JHtmlSidebar::render();

			// Add css
			$doc = JFactory::getDocument();
			$doc->addStyleDeclaration('.icon-48-babioon {background-image: url(../media/babioon/images/icon-48-babioon.png);}');
			$doc->addStyleSheet(JURI::base(true) . '/../media/babioon/css/3x.css');
		}

		$this->addToolbar();
		parent::display();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return	void
	 */
	protected function addToolbar()
	{
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-babioon {background-image: url(../media/babioon/images/icon-48-babioon.png);}');

		$user = JFactory::getUser();
		$canDo = BabioonEventHelper::getActions();
		JToolBarHelper::title(JText::_('COM_BABIOONEVENT'), 'babioon.png');

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_babioonevent');
		}
	}
}
