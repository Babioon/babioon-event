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

jimport('joomla.application.component.view');

/**
 * BabioonEventViewObjects
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewObjects extends BabioonView
{
	/**
	 * Default view, list of items
	 *
	 * @param   string  $tpl  the template
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$title 		= null;
		$name       = $this->getName();

		$state 		= $this->get('State');
		$items 		= $this->get('Items');
		$pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));

			return false;
		}
		$this->assignRef('state', $state);
		$this->assignRef('params', $state->params);

		$this->assignRef('defaultData', $items);
		$this->assignRef('dpage', $pagination);

		$this->assign('showpagination', true);

		if ($this->dpage->get('pages.total') == 1)
		{
			$this->showpagination = false;
		}

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_BABIOONEVENT_' . strtoupper($name)));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);
		$this->assign('title', $title);

		// Headerlevel
		$config = JComponentHelper::getParams('com_babioonevent');
		$this->assign('headerlevel', $config->get('headerlevel', 1));

		parent::display($tpl);
	}
}
