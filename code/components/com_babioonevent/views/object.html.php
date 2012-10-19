<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a address.
 */
class BabioonEventViewObject extends BabioonView
{
	protected $state;
	protected $element;
	protected $params;
	protected $titleposfix=null;
	
	/**
	 * Default view, list of items
	 * 
	 * @param string $tpl
	 */
    function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$title 		= null;
		$name       = $this->getName();
		
		$state 		= $this->get('State');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}
        $this->assignRef('state',$state);
		$this->assignRef('params', $state->params);
	    
		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_BABIOONEVENT_'.strtoupper( $name )));
		}

		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		if (is_null($this->titleposfix) && !empty($this->element->name)) 
		{
		    $this->titleposfix = $this->element->name;
		}
		$this->document->setTitle($title.': '. $this->titleposfix);
		$this->assign('title',$title);
		
		// headerlevel
		$config = JComponentHelper::getParams('com_babioonevent');
		$this->assign('headerlevel',$config->get('headerlevel',1));
		
		parent::display($tpl);
	}
}
