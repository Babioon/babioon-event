<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modellist');

/**
 * This models supports retrieving lists of items.
 *
 * @package		BABIOON_EVENT
 * @subpackage	frontend
 */
class BabioonEventModelEvents extends JModelList
{
    
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
                'id',                  'a.id',
                'name',                'a.name',
                'organiser',           'a.organiser',
                'start',               'a.start',
                'sdate',               'a.sdate',
                'stime',               'a.stime',
                'stimeset',            'a.stimeset',
                'end',                 'a.end',
                'edate',               'a.edate',
                'etime',               'a.etime',
                'etimeset',            'a.etimeset',
                'contact',             'a.contact',
                'email',               'a.email',
                'showemail',           'a.showemail',
                'tel',                 'a.tel',
                'website',             'a.website',
                'emailchecked',        'a.emailchecked',
                'address',             'a.address',
                'ainfo',               'a.ainfo',
                'street',              'a.street',
                'pcode',               'a.pcode',
                'city',                'a.city',
                'state',               'a.state',
                'country',             'a.country',
                'geo_b',               'a.geo_b',
                'geo_l',               'a.geo_l',
                'teaser',              'a.teaser',
                'text',                'a.text',
                'isfreeofcharge',      'a.isfreeofcharge',
                'charge',              'a.charge',
                'picturefile',         'a.picturefile',
                'checked_out',         'a.checked_out',
                'checked_out_time',    'a.checked_out_time',
                'created',             'a.created',
                'created_by',          'a.created_by',
                'created_by_alias',    'a.created_by_alias',
                'modified',            'a.modified',
                'modified_by',         'a.modified_by',
                'published',           'a.published',
                'params',              'a.params',
                'control',             'a.control',
                'catid',               'a.catid',
                'hash',                'a.hash'
			);
		}
		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 */
	protected function populateState($ordering = 'name', $direction = 'ASC')
	{
		$app = JFactory::getApplication();

		// List state information
		$value = $app->input->get('limit', $app->getCfg('list_limit', 0),'uint');
		$this->setState('list.limit', $value);

		$value = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		$orderCol = $app->input->get('filter_order', 'a.name');
		if (!in_array($orderCol, $this->filter_fields)) {
			$orderCol = 'a.name';
		}
		$this->setState('list.ordering', $orderCol);

		$listOrder = $app->input->get('filter_order_Dir', 'ASC');
		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))) {
			$listOrder = 'ASC';
		}
		$this->setState('list.direction', $listOrder);
		
		$params = $app->getParams();
		$this->setState('params', $params);
		$this->setState('filter.language', $app->getLanguageFilter());
		$this->setState('layout', $app->input->get);
	}

	
	/**
	 * Get the master query for retrieving a list of items subject to the model state.
	 *
	 * @return	JDatabaseQuery
	 */
	function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
   		$query->select(
       			$this->getState(
       				'list.select',
       				'a.name,' .
                    'a.sdate,'.
                    'a.stime,'.
                    'a.stimeset,'.
                    'a.edate,'.
                    'a.etime,'.
                    'a.etimeset,'.
       				'a.checked_out, a.checked_out_time, ' .
       				'a.params, a.control, a.state '
       			)
       		)
       		->from('#__babioonevent_events AS a')
       	    ->where('a.state = 1')
    		->order($this->getState('list.ordering', 'a.name').' '.$this->getState('list.direction', 'ASC'));
    		
    	//echo nl2br(str_replace('#__','j25_',$query));
		return $query;
	}

	/**
	 * Method to get a list of items.
	 *
	 * @return	mixed	An array of objects on success, false on failure.
	 */
	public function getItems()
	{
        $Itemid = BabioonEventRouteHelper::getItemid();
		$link = 'index.php?option=com_babioonevent&view=event&layout=default&Itemid='.$Itemid.'&id=';
		
        $items	= (array) parent::getItems();		
		
		for($i=0,$ccount=count($items);$i<$ccount;$i++)
		{
		    $items[$i]->link=$link.$items[$i]->id; 
		}
		return $items;
	}
	
	public function getStart()
	{
		return $this->getState('list.start');
	}
}