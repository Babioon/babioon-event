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

require_once dirname(__FILE__) . '/../objects.html.php';

/**
 * BabioonEventViewEvents
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewEvents extends BabioonEventViewObjects
{
	/**
	 * Default view, list of items
	 *
	 * @param   string  $tpl  used template
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Default is to show the events

		// Feed link
		$parmas = $this->get('State')->params;

		if ($parmas->get('showfeed') != 0)
		{
			$doc      = JFactory::getDocument();
			$Itemid   = BabioonEventRouteHelper::getItemid();
			$feedlink = '<link href="index.php?option=com_babioonevent&amp;view=events&amp;layout=default&amp;Itemid=' . $Itemid . '&amp;format=feed&amp;type=rss" rel="alternate" type="application/rss+xml" title="Veranstaltungen Feed RSS 2.0" />';
			$doc->addCustomTag($feedlink);
			$feedlink = '<link href="index.php?option=com_babioonevent&amp;view=events&amp;layout=default&amp;Itemid=' . $Itemid . '&amp;format=feed&amp;type=atom" rel="alternate" type="application/atom+xml" title="Veranstaltungen Feed Atom 1.0" />';
			$doc->addCustomTag($feedlink);
		}

		$this->assignRef('element', $this->get('Items'));

		parent::display($tpl);
	}
}
