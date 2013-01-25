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

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of address records.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventModelEvents extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see	    JController
	 */
	public function __construct($config = array())
	{
		// Filter fields must match the query fields
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'a.id',
				'a.name',
				'a.organiser',
				'a.sdate',
				'a.edate',
				'a.contact',
				'a.email',
				'a.website',
				'a.city',
				'a.isfreeofcharge',
				'a.published'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	protected function getListQuery()
	{
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
					'list.select',
							'a.id,' .
							'a.name,' .
							'a.organiser,' .
							'a.start,' .
							'a.sdate,' .
							'a.stime,' .
							'a.stimeset,' .
							'a.end,' .
							'a.edate,' .
							'a.etime,' .
							'a.etimeset,' .
							'a.contact,' .
							'a.email,' .
							'a.showemail,' .
							'a.tel,' .
							'a.website,' .
							'a.emailchecked,' .
							'a.address,' .
							'a.ainfo,' .
							'a.street,' .
							'a.pcode,' .
							'a.city,' .
							'a.state,' .
							'a.country,' .
							'a.geo_b,' .
							'a.geo_l,' .
							'a.teaser,' .
							'a.text,' .
							'a.isfreeofcharge,' .
							'a.charge,' .
							'a.picturefile,' .
							'a.checked_out,' .
							'a.checked_out_time,' .
							'a.created,' .
							'a.created_by,' .
							'a.created_by_alias,' .
							'a.modified,' .
							'a.modified_by,' .
							'a.published,' .
							'a.params,' .
							'a.control,' .
							'a.catid,' .
							'a.hash'
			)
		);

		$query->from($db->quoteName('#__babioonevent_events') . ' AS a');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.name LIKE ' . $search . ') OR (a.organiser LIKE ' . $search . ') OR (a.city LIKE ' . $search . ')');
			}
		}
		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published IN (0, 1))');
		}

		// Add the list ordering clause.
		$orderCol	= $this->getState('list.ordering', 'a.name');
		$orderDirn	= $this->getState('list.direction', 'ASC');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Ordering for the query
	 * @param   string  $direction  Ordering direction
	 *
	 * @return void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_babioonevent');
		$this->setState('params', $params);

		// List state information.
		// Column must one of the filter_fields
		parent::populateState('a.street', 'asc');
	}
}
