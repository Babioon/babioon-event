<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * BabioonEvent master display controller.
 */
class BabioonEventController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false)
	{
        // pretty simple
        $app=JFactory::getApplication();
        $view = $app->input->get('view','default');
	    BabioonEventHelper::addSubmenu(JRequest::getCmd('view', 'default') );
	    $app->input->set('view',$view);
		parent::display();
		return $this;
	}
}
