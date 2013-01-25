<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * modBabiooneventEventlistHelper
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class ModBabiooneventEventlistHelper
{
	/**
	 * get the event items
	 *
	 * @param   JRegistry  $params  parameter object
	 *
	 * @return  array
	 */
	public function getItems($params)
	{
		$eventcats  = $params->get('eventcats', array());
		$eventcount = $params->get('eventcount', 5);
		$order      = $params->get('order', 1);
		$Itemid     = BabioonEventRouteHelper::getItemid('events');
		$db         = JFactory::getDBO();
		$now        = gmdate("Y-m-d");

		$query = $db->getQuery(true);
		$query->select('MONTHNAME(e.sdate) AS mon')
				->select('YEAR(e.sdate) AS year')
				->select('e.*')
				->select('cc.title AS cctitle')
				->from('#__babioonevent_events AS e')
				->from('#__categories AS cc')
				->where('(e.sdate >= "' . $now . '" OR e.edate >= "' . $now . '")')
				->where('e.catid = cc.id')
				->where('e.published = 1')
				->where('cc.published = 1')
				->order('e.sdate, cc.title');

		if (!empty($eventcats) && trim($eventcats[0]) != "")
		{
			$catfilter = 'catid in (' . implode(',', $eventcats) . ') ';
			$query->where($catfilter);
		}

		$db->setQuery($query, 0, $eventcount);

		$c      = $db->loadObjectList();
		$ccount = count($c);
		$link   = 'index.php?option=com_babioonevent&view=event' . '&Itemid=' . $Itemid . '&id=';

		$categorylist = array();
		$nr           = array();

		for ($i = 0; $i < $ccount; $i ++)
		{
			$obj       = new stdClass;
			$crow      = $c [$i];
			$obj       = $crow;
			$obj->link = $link . $crow->id;
			$nr []     = $obj;
			$categorylist [$obj->catid] = $obj->cctitle;
		}

		if ($order == 2)
		{
			$result = array();

			if (!empty($eventcats))
			{
				foreach (explode(',', $eventcats) as $elm)
				{
					foreach ($nr as $r)
					{
						if ($elm == $r->catid)
						{
							$result [] = $r;
						}
					}
				}
			}
			else
			{
				if (asort($categorylist, SORT_LOCALE_STRING) === true)
				{
					foreach ($categorylist as $key => $value)
					{
						foreach ($nr as $r)
						{
							if ($key == $r->catid)
							{
								$result [] = $r;
							}
						}
					}
				}
				else
				{
					$result = $nr;
				}
			}
		}
		else
		{
			$result = $nr;
		}

		return $result;
	}
}
