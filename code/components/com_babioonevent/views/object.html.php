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

jimport('joomla.application.component.view');

/**
 * View to edit a address.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewObject extends BabioonView
{
	protected $state;

	protected $element;

	protected $params;

	protected $titleposfix = null;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return	void
	 */
	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$title 		= null;
		$name       = $this->getName();

		$state 		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));

			return false;
		}
		$this->assignRef('state', $state);
		$this->assignRef('params', $state->params);

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

		if (is_null($this->titleposfix) && !empty($this->element->name))
		{
			$this->titleposfix = $this->element->name;
		}
		$this->document->setTitle($title . ': ' . $this->titleposfix);
		$this->assign('title', $title);

		// Headerlevel
		$config = JComponentHelper::getParams('com_babioonevent');
		$this->assign('headerlevel', $config->get('headerlevel', 1));

		parent::display($tpl);
	}
}
