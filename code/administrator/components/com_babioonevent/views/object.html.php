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
class BabioonEventViewObject extends JView
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$name       = $this->getName();
		$doc = JFactory::getDocument();
		if(file_exists(JPATH_BASE.'/media/babioon/images/icon-48-babioon-'.$name.'.png'))
		{
		    $doc->addStyleDeclaration('.icon-48-babioon-'.$name.' {background-image: url(../media/babioon/images/icon-48-babioon-'.$name.'.png);}');
		    $image='babioon-'.$name.'.png';
		}
		else 
		{
		    $doc->addStyleDeclaration('.icon-48-babioon {background-image: url(../media/babioon/images/icon-48-babioon.png);}');
		    $image='babioon.png';    
		}
		
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= BabioonEventHelper::getActions($name);
        
		$tag        = 'COM_BABIOONEVENT_'.strtoupper( $name );
		JToolBarHelper::title($isNew ? JText::_($tag.'_NEW') : JText::_($tag.'_EDIT'), $image);

		// If not checked out, can save the item.
		if (!$checkedOut && $canDo->get('babioonevent.edit')) 
		{
			JToolBarHelper::apply($name.'.apply');
			JToolBarHelper::save($name.'.save');

			if ($canDo->get('babioonevent.create')) {
				JToolBarHelper::save2new($name.'.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('babioonevent.create')) {
			JToolBarHelper::save2copy($name.'.save2copy');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel($name.'.cancel');
		}
		else {
			JToolBarHelper::cancel($name.'.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
