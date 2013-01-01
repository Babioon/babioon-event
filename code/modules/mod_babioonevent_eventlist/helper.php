<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class modBabiooneventEventlistHelper {

	public function getItems($params) 
	{
		$eventcats = $params->get('eventcats', array());
		$eventcount = $params->get ( 'eventcount', 5 );
		$order = $params->get ( 'order', 1 );

		$Itemid = BabioonEventRouteHelper::getItemid ( 'events' );
		$db = JFactory::getDBO ();
		$now = gmdate ( "Y-m-d" ) ;

		$catfilter = '';
		if (!empty($eventcats) && trim($eventcats[0]) != "") 
		{
			$catfilter = ' AND catid in (' . implode ( ',', $eventcats  ) . ') ';
		}

		$query = "SELECT MONTHNAME(e.sdate) as mon,YEAR(e.sdate) as year," .
				"\n e.*, cc.title as cctitle" .
				"\n FROM " .
				"\n  #__babioonevent_events as e, #__categories as cc" .
				"\n WHERE " .
				"\n (e.sdate >= '$now' OR e.edate >= '$now')" .
				"\n AND e.catid = cc.id" .
				"\n AND e.published = 1" .
				"\n AND cc.published = 1" .
				$catfilter .
				"\n ORDER BY e.sdate, cc.title ";

		$db->setQuery ( $query, 0, $eventcount );

		$c = $db->loadObjectList ();
		$ccount = count ( $c );

		$link = 'index.php?option=com_babioonevent&view=event' . '&Itemid=' . $Itemid . '&id=';
		$categorylist = array ( );
		$nr = array ( );
		for($i = 0; $i < $ccount; $i ++) 
		{
			$obj = new stdClass ( );
			$crow = $c [$i];
			$obj = $crow;
			$obj->link = $link . $crow->id;
			$nr [] = $obj;
			$categorylist [$obj->catid] = $obj->cctitle;
		}

		if ($order == 2) {
			$result = array ( );
			if (trim ( $eventcats ) != '') {
				foreach ( explode ( ',', $eventcats ) as $elm ) {
					foreach ( $nr as $r ) {
						if ($elm == $r->catid) {
							$result [] = $r;
						}
					}
				}
			} else {
				if (asort ( $categorylist, SORT_LOCALE_STRING ) === true) {
					foreach ( $categorylist as $key => $value ) {
						foreach ( $nr as $r ) {
							if ($key == $r->catid) {
								$result [] = $r;
							}
						}
					}
				} else {
					$result = $nr;
				}
			}
		} else {
			$result = $nr;
		}
		return $result;
	}
}