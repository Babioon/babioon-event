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

require_once dirname(__FILE__) . '/../objects.html.php';

/**
 * View class for a list of Objects.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewEvents extends BabioonEventViewObjects
{
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.state' => JText::_('JSTATUS'),
			'a.name' => JText::_('COM_BABIOONEVENT_NAME'),
			'a.organiser' => JText::_('COM_BABIOONEVENT_ORGANISER'),
			'a.sdate' => JText::_('COM_BABIOONEVENT_SDATE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	/**
	 * Add the sidebar.
	 *
	 * @return void
	 *
	 * @since   3.0
	 */
	protected function addSidebar()
	{
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_state',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
		);
	}
}
