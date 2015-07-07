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

/**
 * Events Search plugin
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class PlgSearchBabioonevent extends JPlugin
{
	/**
	 * eventRouterLoaded  is the route class loaded
	 * @var boolean
	 */
	protected $eventRouterLoaded = false;

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();

		// Check if babionnevent component installed
		if (file_exists(JPATH_SITE . '/components/com_babioonevent/helpers/route.php'))
		{
			// Load needed file
			require_once JPATH_SITE . '/components/com_babioonevent/helpers/route.php';
			$this->eventRouterLoaded = true;
		}
	}

	/**
	* onContentSearchAreas
	*
	* @return  array  An array of search areas
	*/
	function onContentSearchAreas()
	{
		static $areas = array(
			'events' => 'BABIOONEVENT_PLG_SEARCH_EVENTS'
		);

		return $areas;
	}

	/**
	 * Event Search method
	 *
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 *
	 * @param   string  $text      Target search string
	 * @param   string  $phrase    matching option, exact|any|all
	 * @param   string  $ordering  ordering option, newest|oldest|popular|alpha|category
	 * @param   mixed   $areas     An array if the search it to be restricted to areas, null if search all
	 *
	 * @return  array  searchresults
	 */
	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		if ($this->eventRouterLoaded == false)
		{
			return array();
		}

		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$searchText = $text;
		$searchin   = array();

		if (is_array($areas))
		{
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas())))
			{
				return array();
			}
		}

		$limit	= $this->params->def('search_limit', 50);

		$text = trim($text);

		if ( $text == '' )
		{
			return array();
		}

		switch ($ordering)
		{
			case 'alpha':
				$order = 'a.name ASC';
				break;
			case 'newest':
				$order = 'a.sdate DESC';
				break;
			case 'category':
			case 'popular':
			case 'oldest':
			default:
				$order = 'a.sdate ASC';
		}

		$today = gmdate("Y-m-d");

		// Serach in
		$tags = array('name','organiser','teaser','text','contact','street','city','pcode','ainfo');
		$wheres = array();

		switch ($phrase)
		{
			case 'exact':
				$text		= $db->Quote('%' . $db->getEscaped($text, true) . '%', false);
				$wheres2 	= array();

				for ($i = 0;$i < count($tags);$i++)
				{
					$t = $tags[$i];

					if ($this->params->def('searchin' . $t, 1) == 1)
					{
						$wheres2[] = 'a.' . $t . ' LIKE ' . $text;
						$searchin[] = $t;
					}
				}

				$where = '(' . implode(') OR (', $wheres2) . ')';
				break;
			case 'all':
			case 'any':
			default:
				$words = explode(' ', $text);
				$wheres = array();

				foreach ($words as $word)
				{
					$word		= $db->Quote('%' . $db->getEscaped($word, true) . '%', false);
					$wheres2 	= array();

					for ($i = 0;$i < count($tags);$i++)
					{
						$t = $tags[$i];

						if ($this->params->def('searchin' . $t, 1) == 1)
						{
							$wheres2[] = 'a.' . $t . ' LIKE ' . $word;
							$searchin[] = $t;
						}
					}

					$wheres[] 	= implode(' OR ', $wheres2);
				}

				$where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
				break;
		}

		$query = $db->getQuery(true);
		$query->select('a.babioonevent_event_id AS id')
				->select('a.name AS title')
				->select('CONCAT(a.teaser,a.text) AS text')
				->select('a.created AS created')
				->select('"2" AS browsernav')
				->select('c.title as section')
				->select('a.organiser')
				->select('a.contact')
				->select('a.name')
				->from('#__babioonevent_events as a')
				->join('LEFT', '#__categories AS c ON a.catid = c.id')
				->where($where)
				->where('a.sdate >= "' . $today . '"')
				->where('a.enabled = 1')
				->where('c.published = 1')
				->group('a.babioonevent_event_id')
				->order($order);

		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();
		$return = array();

		if (!empty($rows))
		{
			// Get an itemid
			$Itemid = BabioonEventRouteHelper::getItemid('events');
			$link  = 'index.php?option=com_babioonevent&view=event&layout=item&Itemid=' . $Itemid . '&id=';
			$count = count($rows);

			for ( $i = 0; $i < $count; $i++ )
			{
				$event = $rows[$i];
				$event->href = $link . $event->id;

				if (searchHelper::checkNoHTML($event, $searchText, $searchin))
				{
					$return[] = $event;
				}
			}
		}

		return $return;
	}
}
