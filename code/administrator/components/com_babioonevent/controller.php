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

jimport('joomla.application.component.controller');

/**
 * BabioonEvent master display controller.
 *
 * @package  BABIOON_UPCC
 * @since    2.0
 */
class BabioonEventController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types,for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Pretty simple
		$app	= JFactory::getApplication();
		$view 	= $app->input->get('view', 'events');
		BabioonEventHelper::addSubmenu($view);
		$app->input->set('view', $view);
		parent::display();

		return $this;
	}
}
