<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

/**
 * class BabioonEventViewDefault
 *
 * @package BABIOON_EVENT
 */
class BabioonEventViewDefault extends JView
{

	/**
	 * Display the view
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
        $this->addToolbar();	    
		parent::display();
	}
	
	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
        $doc = JFactory::getDocument();
        $doc->addStyleDeclaration('.icon-48-babioon {background-image: url(../media/babioon/images/icon-48-babioon.png);}');

		$user = JFactory::getUser();
		$canDo = BabioonEventHelper::getActions();
		JToolBarHelper::title(JText::_('COM_BABIOONEVENT'), 'babioon.png');

		if ($canDo->get('babioonevent.admin'))
		{
			JToolBarHelper::preferences('com_babioonevent');
		}
	}	
}
