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
 * View class for a list of Objects.
 *
 * @package     BABIOON_EVENT
 */
class BabioonEventViewObjects extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
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
		$name       = $this->getName();
		$tag        = strtoupper($name);
		$sigular    = BabioonEventHelper::toSigular($name);
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
	    	    
		$user = JFactory::getUser();
		$canDo = BabioonEventHelper::getActions($sigular);
		JToolBarHelper::title(JText::_('COM_BABIOONEVENT_'.$tag), $image);
		// use sigular
		JToolBarHelper::addNew($sigular.'.add');
		JToolBarHelper::editList($sigular.'.edit');

		if ($canDo->get('babioonevent.edit.state'))
		{
			if ($this->state->get('filter.state') != 2)
			{
				JToolBarHelper::divider();
				JToolBarHelper::publish($sigular.'.publish', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::unpublish($sigular.'.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}

			if ($this->state->get('filter.state') != -1)
			{
				JToolBarHelper::divider();
				if ($this->state->get('filter.state') != 2)
				{
					JToolBarHelper::archiveList($sigular.'.archive');
				}
				elseif ($this->state->get('filter.state') == 2)
				{
					JToolBarHelper::unarchiveList($sigular.'.publish');
				}
			}
		}

		if ($canDo->get('babioonevent.edit.state'))
		{
			JToolBarHelper::checkin($sigular.'.checkin');
		}

		if ($this->state->get('filter.state') == -2 && $canDo->get('babioonevent.delete'))
		{
			JToolBarHelper::deleteList('', $sigular.'.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($canDo->get('babioonevent.edit.state'))
		{
			JToolBarHelper::trash($sigular.'.trash');
			JToolBarHelper::divider();
		}

		if ($canDo->get('babioonevent.admin'))
		{
			JToolBarHelper::preferences('com_babioonevent');
		}
	}
}
