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

jimport('joomla.application.component.modelitem');


/**
 * BabioonEventModelEvent
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventModelEvent extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'com_babioonevent.event';

	/**
	 * names of the date and time fields used in this class
	 *
	 * @var array
	 */
	protected $dateandtimefields = null;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->dateandtimefields = array('sdate','edate','stime','etime');

		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_babioonevent/tables');
		$app = JFactory::getApplication('site');

		// Load the parameters.
		$this->params = $app->getParams();

		parent::__construct();
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->get('id', 'uint');
		$this->setState('event.id', $pk);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
	}

	/**
	 * Method to get item data.
	 *
	 * @param   integer  $pk  The id of the item.
	 *
	 * @return	mixed	Menu item data object on success, false on failure.
	 */
	public function &getItem($pk = null)
	{
		// Initialise variables.
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('event.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{

			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true);
				$query->select(
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
				);
				$query->from('#__babioonevent_events AS a');

				// Filter
				$query->where('a.published = 1');
				$query->where('a.id = ' . (int) $pk);
				$db->setQuery($query);
				$data = $db->loadObject();

				if ($error = $db->getErrorMsg())
				{
					throw new Exception($error);
				}

				if (empty($data))
				{
					return JError::raiseError(404, JText::_('COM_BABIOONEVENT_EVENT_ERROR_NOT_FOUND'));
				}

				// Convert parameter fields to objects.
				$registry = new JRegistry;
				$registry->loadString($data->params);

				$data->params = clone $this->getState('params');
				$data->params->merge($registry);

				$this->_item[$pk] = $data;
			}
			catch (JException $e)
			{
				if ($e->getCode() == 404)
				{
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				}
				else
				{
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}
		return $this->_item[$pk];
	}

	/**
	 * create  an array as form description
	 *
	 * @param   string  $type  form type
	 *

	 * @return  array          formfields
	 */
	public function getForm($type='default')
	{
		$result = array();
		$fconf = $this->params;

		switch ($type)
		{
			case 'export':
				$result[] = array('name' => 'sdate',  'mandatory' => 1, 'error' => 0,'value' => '','vtype' => 'date','type' => 'dateselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_EXSDATE');
				$result[] = array('name' => 'edate',  'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'date','type' => 'dateselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_EXEDATE');
				$result[] = array('name' => 'excatid', 'mandatory' => 1, 'error' => 0,'value' => '1','vtype' => 'int','type' => 'categorycheckboxes','mask' => 0,'labletag' => 'COM_BABIOONEVENT_EXCATID');
				break;
			case 'search':
				$result[] = array('name' => 'fulltext', 'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_FULLTEXT');
				$result[] = array('name' => 'onlyfreeofcharge',  'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'int','type' => 'checkbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_ONLYFREEOFCHARGE');
				$result[] = array('name' => 'sdate',  'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'date','type' => 'dateselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_SDATE');
				$result[] = array('name' => 'edate',  'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'date','type' => 'dateselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_EDATE');
				$confvar = $fconf->get('showlocation', 2);

				if ($confvar > 3)
				{
					$result[] = array('name' => 'pcodefrom', 'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'int','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_PCODEFROM');
					$result[] = array('name' => 'pcodeupto', 'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'int','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_PCODEUPTO');
				}
				$result[] = array('name' => 'catid', 'mandatory' => 1, 'error' => 0,'value' => '1','vtype' => 'int','type' => 'categorycheckboxes','mask' => 0,'labletag' => 'COM_BABIOONEVENT_CATID');
				break;

			case 'add':
			default:

				// Name is always mandatory
				$result[] = array('name' => 'name', 'mandatory' => 1, 'error' => 0, 'value' => '', 'vtype' => 'string', 'type' => 'inputbox', 'mask' => 0,'labletag' => 'COM_BABIOONEVENT_NAME');
				$confvar = $fconf->get('showorganiser', 2);

				if ($confvar != 0)
				{
					$mandatory = $confvar == 2;
					$result[] = array('name' => 'organiser', 'mandatory' => $mandatory, 'error' => 0, 'value' => '', 'vtype' => 'string', 'type' => 'inputbox', 'mask' => 0, 'labletag' => 'COM_BABIOONEVENT_ORGANISER');
				}
				$confvar = $fconf->get('showdates', 4);

				if ($confvar != 0)
				{
					$mandatory = ( ($confvar >= 3  &&  $confvar <= 5) || ($confvar >= 9) );
					$result[] = array('name' => 'sdate',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'date','type' => 'dateselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_SDATE');

					if ($confvar == 2||$confvar == 4||$confvar == 5||$confvar == 7||$confvar == 8||($confvar >= 10 && $confvar != 14) )

					{
						$mandatory = (($confvar == 5)||($confvar == 11)||($confvar == 13)||($confvar == 16)||($confvar == 18)||($confvar == 19));
						$result[] = array('name' => 'stime',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'timeselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_STIME');
					}
					if ( $confvar >= 6 )
					{
						$mandatory = ($confvar >= 14);
						$result[] = array('name' => 'edate',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'date','type' => 'dateselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_EDATE');

						if ($confvar == 8||$confvar == 12||$confvar == 13||$confvar >= 17 )
						{
							$mandatory = ($confvar == 19);
							$result[] = array('name' => 'etime',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'timeselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_ETIME');
						}
					}
				}
				$confvar = $fconf->get('showcontact', 1);

				if ( $confvar != 0 )
				{
					$mandatory = ($confvar == 2);
					$result[] = array('name' => 'contact', 'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_CONTACT');
				}
				$confvar = $fconf->get('showphone', 1);

				if ( $confvar != 0 )
				{
					$mandatory = ($confvar == 2);
					$result[] = array('name' => 'tel', 'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_TEL');
				}
				$confvar = $fconf->get('showwebsite', 1);

				if ( $confvar != 0 )
				{
					$mandatory = ($confvar == 2);
					$result[] = array('name' => 'website', 'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_WEBSITE');
				}
				$confvar = $fconf->get('showemail', 1);

				if ( $confvar != 0 )
				{
					$mandatory = ($confvar == 2);
					$result[] = array('name' => 'email', 'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_EMAIL');
					$result[] = array('name' => 'showemail',  'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'int','type' => 'checkbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_SHOWEMAIL');
				}
				$confvar = $fconf->get('showlocation', 2);

				if ($confvar != 0)
				{
					if ($confvar < 3)
					{
						// 1 field
						$mandatory = ($confvar == 2);
						$result[] = array('name' => 'address',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'textbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_ADDRESS');
					}
					else
					{
						// Split information
						$mandatory = ($confvar >= 4);
						$result[] = array('name' => 'ainfo',  'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_AINFO');
						$result[] = array('name' => 'street',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_STREET');
						$result[] = array('name' => 'pcode',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_PCODE');
						$result[] = array('name' => 'city',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_CITY');
					}
				}
				$confvar = $fconf->get('showshortdesc', 2);

				if ($confvar != 0)
				{
					$mandatory = ($confvar == 2);
					$result[] = array('name' => 'teaser',  'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'textbox','mask' => 2,'labletag' => 'COM_BABIOONEVENT_TEASER');
				}
				$confvar = $fconf->get('showlongdesc', 2);

				if ($confvar != 0)
				{
					$mandatory = ($confvar == 2);
					$result[] = array('name' => 'text', 'mandatory' => $mandatory, 'error' => 0,'value' => '','vtype' => 'string','type' => 'textbox','mask' => 2,'labletag' => 'COM_BABIOONEVENT_TEXT');
				}
				$result[] = array('name' => 'isfreeofcharge',  'mandatory' => 1, 'error' => 0,'value' => '','type' => 'int','type' => 'radio0','mask' => 0,'labletag' => 'COM_BABIOONEVENT_ISFREEOFCHARGE');
				$result[] = array('name' => 'charge', 'mandatory' => 0, 'error' => 0,'value' => '','vtype' => 'string','type' => 'inputbox','mask' => 0,'labletag' => 'COM_BABIOONEVENT_CHARGE');
				$confvar = $fconf->get('showcategory', 1);

				if ($confvar != 0)
				{
					$result[] = array('name' => 'catid', 'mandatory' => 1, 'error' => 0,'value' => '','vtype' => 'int','type' => 'categoryselect','mask' => 0,'labletag' => 'COM_BABIOONEVENT_CATID');
				}
				break;
		}
		return $result;
	}

	/**
	 * merge all time fields and save the information in the session
	 *
	 * @return  void
	 */
	private function mergeDateFields()
	{
		$this->setUserState('sdate', $this->checkDate('sdate'));
		$this->setUserState('edate', $this->checkDate('edate'));
	}

	/**
	 * merge all date fields and save the information in the session
	 *
	 * @return  void
	 */
	private function mergeTimeFields()
	{
		$this->setUserState('stime', $this->checkTime('stime'));
		$this->setUserState('etime', $this->checkTime('etime'));
	}

	/**
	 * checks the form values
	 *
	 * @param   array  $form  the form
	 *
	 * @return  array         form and errors
	 */
	public function checkValuesEventForm($form)
	{
		$error 		= array();
		$nform 		= array();
		$now		= JFactory::getDate()->format("Y-m-d");
		$input      = JFactory::getApplication('site')->input;

		// Merge the Date and Time fields
		$this->mergeDateFields();
		$this->mergeTimeFields();

		foreach ($form as $elm)
		{
			if ($elm['type'] == 'checkbox' )
			{
				if ($input->getCmd('task', '') == 'change')
				{
					$val = $this->getUserStateFromRequest($elm['name'], null, 'none', $elm['mask']);
				}
				else
				{
					$val = $input->getInt($elm['name'], 0);
				}
			}
			else
			{
				if (in_array($elm['name'], $this->dateandtimefields))
				{
					$val = $this->getUserState($elm['name']);
				}
				else
				{
					$val = $this->getUserStateFromRequest($elm['name'], null, 'none', $elm['mask']);
				}
			}
			if ($elm['mandatory'] == 1)
			{
				if ($val == '')
				{
					$tag     = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG';
					$error[] = JText::_($tag);
					$elm['error'] = 1;
				}
				else
				{
					if ($elm['name'] == 'email')
					{
						$regexp = '/^.+@.+\..+$/';

						if (preg_match($regexp, $val) == 0)
						{
							$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG';
							$error[] = JText::_($tag);
							$elm['error'] = 1;
						}
					}
					if ($elm['name'] == 'teaser')
					{
						if (strlen($val) > 300)
						{
							$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG';
							$error[] = JText::_($tag);
							$elm['error'] = 1;
						}
					}
				}
				if ($elm['name'] == 'sdate')
				{
					if ($val !== false)
					{
						// Sdate set and valid
						// Ok get stime
						$t = $this->getUserStateFromRequest('stime');

						if ($t !== false)
						{
							$startdate = $val . ' ' . $t;
						}
						else
						{
							$startdate = $val . ' 00:00';
						}
						if ($startdate <= $now)
						{
							$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG2';
							$error[] = JText::_($tag);
							$elm['error'] = 1;
						}
					}
				}

				if ($elm['name'] == 'edate')
				{
					if ($val !== false)
					{
						// Edate set and valid
						// Ok get etime
						$t = $this->getUserStateFromRequest('etime');

						if ($t !== false)
						{
							$enddate = $val . ' ' . $t;
						}
						else
						{
							$enddate = $val . ' 00:00';
						}

						// Do we have a startdate ?
						$sd = $this->getUserStateFromRequest('sdate');

						if ($sd !== false)
						{
							// We have, what is with the stime
							$t = $this->getUserStateFromRequest('stime');

							if ($t !== false)
							{
								$startdate = $val . ' ' . $t;
							}
							else
							{
								$startdate = $val . ' 00:00';
							}
							if ( $enddate < $startdate||$enddate < $now )
							{
								$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG2';
								$error[] = JText::_($tag);
								$elm['error'] = 1;
							}
						}
						else
						{
							if ( $enddate < $now )
							{
								$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG3';
								$error[] = JText::_($tag);
								$elm['error'] = 1;
							}
						}
					}
				}
			}
			if ($elm['name'] == 'isfreeofcharge')
			{
				$isfreeofcharge = $val == 1;
			}
			if ( $elm['name'] == 'charge' && !$isfreeofcharge && $val == ''  )
			{
				$tag = 'COM_BABIOONEVENT_' . strtoupper($elm['name']) . 'ERRORMSG';
				$error[] = JText::_($tag);
				$elm['error'] = 1;
			}
			$elm['value'] = $val;

			// Save values in a session
			$this->setUserState($elm['name'], $elm['value']);
			$nform[] = $elm;
		}

		return array($nform,$error);
	}

	/**
	 * get the export data based on the given values
	 *
	 * @return array
	 */
	public function getExportData()
	{
		$conf = $this->params;
		$now		= JFactory::getDate()->format("Y-m-d");
		$input      = JFactory::getApplication('site')->input;
		$db 		= $this->getDbo();

		$sdate 		= $this->getUserState('sdate');
		$edate 		= $this->getUserState('edate');
		$excatid 	= $this->getUserState('excatid');

		$where[] = 'e.catid = cc.id';
		$where[] = 'e.published = 1';
		$where[] = 'cc.published = 1';
		$where[] = 'e.catid in ( ' . $excatid . ') ';

		if ($sdate !== false)
		{
			$where[] = 'e.sdate >= "' . $sdate . '" ';
		}

		if ($edate !== false)
		{
			$where[] = 'e.edate <= "' . $edate . '"';
			$where[] = 'e.sdate < "' . $edate . '"';
		}

		$where 		= count($where) ? "\n" . implode(' AND ', $where) : '';
		$farray		= array();
		$fields  = array('organiser','start','end','contact','email','tel','website','address','teaser','text','isfreeofcharge','charge');

		foreach ($fields as $elm)
		{
			if ($conf->get('export' . $elm) == 1)
			{
				switch ($elm)
				{
					case 'start':
						$farray[] = 'IF(stimeset = 1, CONCAT(e.sdate," ",e.stime), e.sdate) AS start';
						break;
					case 'end':
						$farray[] = 'IF(etimeset = 1, CONCAT(e.edate," ",e.etime), e.edate) AS end';
						break;
					case 'address':
						// Separate field, if empty is in old entry
						$farray[] = 'IF(street <> "",CONCAT(IF(ainfo<>"",CONCAT(ainfo,", "),""),street,IF(pcode<>"",CONCAT(", ",pcode),""),IF(city<>"",CONCAT(" ",city),"") ),address) AS address';
						break;
					default:
						$farray[] = 'e.' . $elm;
						break;
				}
			}
		}
		$ftxt  = count($farray) ? ', ' . implode(', ', $farray) : '';

		$query = $db->getQuery(true);
		$query->select("e.stimeset,e.etimeset,e.showemail, e.name " . $ftxt . ", cc.title as cctitle")
				->from("#__babioonevent_events as e")
				->from("#__categories as cc")
				->where($where)
				->order('e.sdate,e.stime,e.edate,e.etime');
		$db->setQuery($query);

		$this->data = $db->loadAssocList();

		return $this->data;
	}

	/**
	 * create the export files and returns the filenames
	 *
	 * @return array filenames
	 */
	public function getExportFile()
	{
		$conf = $this->params;
		$exportfiles = $conf->get('exportfiles', 1);

		if ($exportfiles == 0)
		{
			// Do nothing but return the correct valuetype
			return array('','');
		}

		$filename	= false;
		$filename2	= false;
		$this->getExportData();
		$cr = count($this->data);

		if ( $cr != 0 )
		{
			// Rel dir to siteroot
			$exportdir = $conf->get('exportdir');
			$glue = $conf->get('exportglue', ';');
			$quote = $conf->get('exportquote', 0);
			$codepage = $conf->get('export_codepage', 1);

			switch ($codepage)
			{
				default:
				case "1":
					$codepage = 'CP1252';
					break;
				case "2":
					$codepage = 'ISO-8859-1';
					break;
				case "3":
					$codepage = 'UTF-8';
					break;
			}
			$adir = JPATH_ROOT . DS . $exportdir;

			if ($exportfiles == 1 || $exportfiles == 3)
			{
				$filename = BabioonUtilities::getFilename($adir, 'export', 'csv');
			}

			if ($filename !== false)
			{
				$result_fields = array_keys($this->data[0]);
				$head_fields   = array_slice($result_fields, 3);

				$headline = '';

				foreach ($head_fields as $e)
				{
					$nr [] = JText::_('COM_BABIOONEVENT_EXPORTHEAD_' . strtoupper($e));
				}
				if ($quote == 1)
				{
					$headline = '"' . implode('"' . $glue . '"', $nr) . '"' . "\n";
				}
				else
				{
					$headline = implode($glue, $nr) . "\n";
				}

				// Format fields
				for ($i = 0;$i < $cr;$i++)
				{
					$r =	$this->data[$i];

					if ($r['showemail'] == 0 AND in_array('email', $head_fields))
					{
						$r['email'] = '';
					}

					if (in_array('start', $head_fields))
					{
						if ($r['stimeset'] == 1)
						{
							$r['start'] = date($conf->get('sformat', 'd.m.Y H:i'), strtotime($r['start']));
						}
						else
						{
							$r['start'] = date($conf->get('sformat', 'd.m.Y'), strtotime($r['start']));
						}
					}
					if (in_array('end', $head_fields))
					{
						if ($r['etimeset'] == 1)
						{
							$r['end'] = date($conf->get('sformat', 'd.m.Y H:i'), strtotime($r['end']));
						}
						else
						{
							if ($r['end'] == '0000-00-00')
							{
								$r['end'] = '';
							}
							else
							{
								$r['end'] = date($conf->get('sformat', 'd.m.Y'), strtotime($r['end']));
							}
						}
					}
					if (in_array('isfreeofcharge', $head_fields))
					{
						$r['isfreeofcharge'] = $r['isfreeofcharge'] ? JText::_('JYES') : JText::_('JNO');
					}
					if (in_array('address', $head_fields))
					{
						$r['address'] = BabioonUtilities::html2txt($r['address']);
					}
					if (in_array('teaser', $head_fields))
					{
						$r['teaser'] = BabioonUtilities::html2txt($r['teaser']);
					}
					if (in_array('text', $head_fields))
					{
						$r['text'] = BabioonUtilities::html2txt($r['text']);
					}
					unset($r['stimeset']);
					unset($r['etimeset']);
					unset($r['showemail']);

					foreach (array_keys($r) as $e)
					{
						if ($quote == 1)
						{
							$r[$e] = '"' . str_replace('"', "'", $r[$e]) . '"';
						}
						else
						{
							// Replace all GLUE in text
							$r[$e] = str_replace($glue, ' ', $r[$e]);
						}
					}
					$this->data[$i] = $r;
				}
				$handle = fopen(JPATH_ROOT . DS . $exportdir . DS . $filename, 'w+');
				fwrite($handle, $headline);

				for ($i = 0;$i < $cr;$i++)
				{
					$r     = $this->data[$i];
					$line  = implode($glue, $r);
					$line .= "\n";

					if ($codepage != 'UTF-8')
					{
						$line = iconv("UTF-8", $codepage, $line);
					}
					fputs($handle, $line);
				}
				fclose($handle);
				$filename = $exportdir . DS . $filename;

				if (DS != '/')
				{
					$filename = str_replace('\\', '/', $filename);
				}
				$result[] = $filename;
			}
			else
			{
				$result[] = '';
			}

			$txt = ($exportfiles == 2) || ($exportfiles == 3);

			if ($txt)
			{
				$filename2 = BabioonUtilities::getFilename($adir, 'export', 'txt');
			}
			if ($filename2 !== false)
			{
				$txt = array();

				// Format fields
				for ($i = 0;$i < $cr;$i++)
				{
					$r    = $this->data[$i];
					$text = '';

					if (in_array('start', $head_fields))
					{
						$text .= trim($r['start'], '"');
					}
					if (in_array('end', $head_fields) && trim($r['end'], '"') != '')
					{
						$text .= ' - ' . trim($r['end'], '"');
					}
					$text .= "\n";
					$text .= trim($r['name'], '"');
					$text .= "\n";

					if ( in_array('address', $head_fields) )
					{
						$text .= trim(BabioonUtilities::html2txt($r['address']), '"');
						$text .= "\n";
					}
					if (in_array('organiser', $head_fields))
					{
						$text .= trim(BabioonUtilities::html2txt($r['organiser']), '"');
						$text .= "\n";
					}
					$txt[] = $text;
				}

				$handle = fopen(JPATH_ROOT . DS . $exportdir . DS . $filename2, 'w+');

				for ($i = 0;$i < $cr;$i++)
				{
					$line = $txt[$i] . "\n";

					if ($codepage != 'UTF-8')
					{
						$line = iconv("UTF-8", $codepage,  $line);
					}
					fputs($handle, $line);
				}
				fclose($handle);
				$filename2 = $exportdir . DS . $filename2;

				if (DS != '/')
				{
					$filename2 = str_replace('\\', '/', $filename2);
				}
				$result[] = $filename2;
			}
			else
			{
				$result[] = '';
			}
		}
		return $result;

	}

	/**
	 * checks the form values
	 *
	 * @param   array  $form  the form
	 *
	 * @return  array         form and errors
	 */
	public function getSearchData($form)
	{
		$Itemid 	= BabioonEventRouteHelper::getItemid();
		$now		= JFactory::getDate()->format("Y-m-d");
		$input      = JFactory::getApplication('site')->input;
		$db 		= $this->getDbo();
		$params 	= $this->params;

		$where 		= array();

		$limitstart = $input->getInt('limitstart', '0');
		$limit		= $this->getUserStateFromRequest('limit', $params->get('defaultlistlength', 25), 'int');
		$start 		= $now;

		foreach ($form as $elm)
		{
			$val = trim($this->getUserState($elm['name']));

			switch ($elm['name'])
			{
				case 'fulltext':
					if (trim($val) != '')
					{
						$quotedstring = $db->Quote('%' . $val . '%');
						$fields = array('name','organiser','contact','tel','website','address','teaser','text','street','pcode','city','ainfo');
						$w = array();

						foreach ($fields as $f)
						{
							$w[] = 'e.' . $f . ' like ' . $quotedstring;
						}

						$where[] = '(' . implode(' OR ', $w) . ')';
					}
					break;
				case 'onlyfreeofcharge':
					if ($val == 1)
					{
						$where[] = 'isfreeofcharge = 1';
					}
					break;
				case 'sdate':
					if (trim($val) != '')
					{
						$start = $val;
					}
					break;
				case 'edate':
					if (trim($val) != '')
					{
						$where[] = '(e.edate < "' . $val . '" OR e.date = "0000-00-00")';
					}
					break;
				case 'pcodefrom':
					if (trim($val) != '')
					{
						$where[] = 'e.pcode >= "' . $val . '"';
					}
					break;
				case 'pcodeupto':
					if (trim($val) != '')
					{
						$where[] = 'e.pcode <= "' . $val . '"';
					}
					break;
				case 'catid':
					if (trim($val) != '')
					{
						$where[] = 'catid in (' . $val . ')';
					}
					break;
			}
		}

		$where[] = 'e.sdate > "' . $start . '" ';
		$where[] = 'e.catid = cc.id';
		$where[] = 'e.published = 1';
		$where[] = 'cc.published = 1';

		$where 		= count($where) ? "\n" . implode(' AND ', $where) : '';
		$orderby 	= ' ORDER BY  e.start,e.name';

		$query = $db->getQuery(true);
		$query->select("count(*)")
				->from("#__babioonevent_events as e")
				->from("#__categories as cc")
				->where($where);

		$db->setQuery($query);
		$ccount = $db->loadResult();
		$this->page = new JPagination($ccount, $limitstart, $limit);

		$query->clear('select')
			->select("MONTHNAME(e.sdate) as mon,YEAR(e.sdate) as year,e.*, cc.title as cctitle")
			->orderby($orderby);

		$db->setQuery($query, $limitstart, $limit);
		$c = $db->loadObjectList();
		$link = 'index.php?option=com_babioonevent&view=event&Itemid=' . $Itemid . '&id=';
		$nr = array();

		for ($i = 0;$i < count($c);$i++)
		{
			$obj       = new stdClass;
			$crow      = $c[$i];
			$obj       = $crow;
			$obj->link = $link . $crow->id;
			$nr[]      = $obj;
		}
		$this->data = $nr;

		return $nr;
	}

	/**
	 * checks the form values
	 *
	 * @param   array  $form  the form
	 *
	 * @return  array         form and errors
	 */
	public function checkvaluesSearch($form)
	{
		$error 		= array();
		$nform 		= array();
		$input 		= JFactory::getApplication('site')->input;

		$startsearch = $input->getInt('startsearch', 0);

		foreach ($form as $elm)
		{
			if ($startsearch)
			{
				// Merge the Date fields
				$this->mergeDateFields();

				// Get all values out of the request
				if ($elm['type'] == 'categorycheckboxes')
				{
					// Get the categories
					$val = trim(implode(',', $input->getArray('catid', array())));
				}
				else
				{
					if ($elm['name'] != 'sdate' && $elm['name'] != 'edate')
					{
						$val = $input->getString($elm['name']);
					}
				}
				if ($elm['mandatory'] == 1)
				{
					if ($val == '')
					{
						$tag = strtoupper('COM_BABIOONEVENT_SEA' . $elm['name']) . 'ERRORMSG';
						$error[] = JText::_($tag);
						$elm['error'] = 1;
					}
					else
					{
						if ($elm['name'] == 'sdate')
						{
							if ($val !== false)
							{
								// Sdate set and valid
								if ($val <= $now)
								{
									$tag = strtoupper('COM_BABIOONEVENT_SEA' . $elm['name']) . 'ERRORMSG2';
									$error[] = JText::_($tag);
									$elm['error'] = 1;
								}
							}
						}
						if ($elm['name'] == 'edate')
						{
							if ($val !== false)
							{
								// Edate set and valid
								// Do we have a startdate ?
								$sd = $this->getUserStateFromRequest('sdate');

								if ($sd !== false)
								{
									// We have
									if ($val < $sd||$val < $now)
									{
										$tag = strtoupper('COM_BABIOONEVENT_SEA' . $elm['name']) . 'ERRORMSG2';
										$error[] = JText::_($tag);
										$elm['error'] = 1;
									}
								}
								else
								{
									if ( $val < $now )
									{
										$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG3';
										$error[] = JText::_($tag);
										$elm['error'] = 1;
									}
								}
							}
						}
					}
				}
				$elm['value'] = $val;

				// Save values in a session
				$this->setUserState($elm['name'], $elm['value']);
				$nform[] = $elm;
			}
			else
			{
				$val = $this->getUserState($elm['name']);
				$elm['value'] = $val;
				$nform[] = $elm;
			}
		}
		return array($nform,$error);
	}

	/**
	 * checks the form values
	 *
	 * @param   array  $form  the form
	 *
	 * @return  array         form and errors
	 */
	public function checkValuesExportForm($form)
	{
		$error 		= array();
		$nform 		= array();
		$now		= JFactory::getDate()->format("Y-m-d");
		$input      = JFactory::getApplication('site')->input;

		// Merge the Date and Time fields
		$this->mergeDateFields();

		foreach ($form as $elm)
		{
			if ( $elm['type'] == 'categorycheckboxes' )
			{
				// Get the categories
				$excatid = $input->get('excatid', array(), 'array');
				$val = trim(implode(',', $excatid));
			}
			else
			{
				$val = $this->getUserState($elm['name']);
			}
			if ($elm['mandatory'] == 1)
			{
				if ($val == '')
				{
					$tag = strtoupper('COM_BABIOONEVENT_EX' . $elm['name']) . 'ERRORMSG';
					$error[] = JText::_($tag);
					$elm['error'] = 1;
				}
				else
				{
					if ($elm['name'] == 'sdate')
					{
						if ($val !== false)
						{
							// Sdate set and valid
							if ($val <= $now)
							{
								$tag = strtoupper('COM_BABIOONEVENT_EX' . $elm['name']) . 'ERRORMSG2';
								$error[] = JText::_($tag);
								$elm['error'] = 1;
							}
						}
					}
					if ($elm['name'] == 'edate')
					{
						if ($val !== false)
						{
							// Edate set and valid
							// Do we have a startdate ?
							$sd = $this->getUserStateFromRequest('sdate');

							if ($sd !== false)
							{
								// We have
								if ( $val < $sd||$val < $now )
								{
									$tag = strtoupper('COM_BABIOONEVENT_EX' . $elm['name']) . 'ERRORMSG2';
									$error[] = JText::_($tag);
									$elm['error'] = 1;
								}
							}
							else
							{
								if ( $val < $now )
								{
									$tag = strtoupper('COM_BABIOONEVENT_' . $elm['name']) . 'ERRORMSG3';
									$error[] = JText::_($tag);
									$elm['error'] = 1;
								}
							}
						}
					}
				}
			}
			$elm['value'] = $val;

			// Save values in a session
			$this->setUserState($elm['name'], $elm['value']);
			$nform[] = $elm;
		}

		return array($nform,$error);
	}

	/**
	 * checks if a Date is valid
	 *
	 * @param   string  $what  what date type
	 *
	 * @return  string         the date on sucess or false on fail
	 */
	private function checkDate($what='sdate')
	{
		$result = false;
		$val	= (int) trim($this->getUserStateFromRequest($what));
		$dd 	= trim($this->getUserStateFromRequest($what . '-dd', ''));
		$mm 	= trim($this->getUserStateFromRequest($what . '-mm', ''));

		if ($val != '' && $dd != '' && $mm != '')
		{
			if (!checkdate($mm, $dd, $val))
			{
				$result = false;
			}
			else
			{
				$result	= $val . '-' . $mm . '-' . $dd;
			}
		}
		return $result;
	}

	/**
	 * checks if a time is valid
	 *
	 * @param   string  $what  what date type
	 *
	 * @return  string         the time on sucess or false on fail
	 */
	private function checkTime($what='stime')
	{
		$result = false;
		$hh 	= trim($this->getUserStateFromRequest($what . '_h', '--'));
		$mm 	= trim($this->getUserStateFromRequest($what . '_m', '--'));

		if ($hh != '--' && $mm != '--')
		{
			$hint = (int) $hh;
			$mint = (int) $mm;

			if (($hint >= 0) && ($hint <= 23) && ($mint >= 0) && ($hint <= 59))
			{
				$hh = str_pad($hint, 2, "0", STR_PAD_LEFT);
				$mm = str_pad($mint, 2, "0", STR_PAD_LEFT);
				$result	= $hh . ':' . $mm;
			}
		}

		return $result;
	}

	/**
	 * bind the session data to a object
	 *
	 * @param   object  &$row  the data
	 * @param   string  $form  name of the from
	 *
	 * @return void
	 */
	private function bindDataToRow(&$row,$form='add')
	{
		// Merge the Date and Time fields
		$this->mergeDateFields();
		$this->mergeTimeFields();

		$ignore = array('stime_h','stime_m','etime_h','etime_m');
		$form = $this->getForm($form);

		foreach ($form as $elm)
		{
			if (!in_array($elm['name'], $ignore))
			{
				$row->$elm['name'] = $this->getUserState($elm['name']);
			}
		}
	}

	/**
	 * save a new event, get the information out of the session-content
	 *
	 * @return mixed true on success, error if save failed
	 */
	public function saveFormData()
	{
		// Simple check for spam
		$input     = JFactory::getApplication('site')->input;
		$hereweare = $input->getString('hereweare', 'blubb');

		if ($hereweare == $this->getUserState('hereweare'))
		{
			$app = JFactory::getApplication('site');

			// Load the parameters.
			$this->params = $app->getParams();

			$row	= $this->getTable('event', 'BabioonEventTable');

			$this->bindDataToRow($row);
			$row->created 			= gmdate("Y-m-d H:i:s");
			$row->created_by 		= 0;
			$row->created_by_alias 	= 'Website';
			$row->published 		= 0;

			$row->stimeset 			= $this->getUserState('stime') !== false;
			$row->etimeset 			= $this->getUserState('etime') !== false;

			$confvar = $this->params->get('showcategory', 1);

			if ($confvar == 0)
			{
				$defcat = $this->params->get('defaultcategory', 0);

				if ($defcat == 0)
				{
					return JError::raiseWarning(500, 'default category not set');
				}
				$row->catid = $defcat;
			}

			if (!$row->check())
			{
				return JError::raiseWarning(500, $row->getError());
			}

			if (!$row->store())
			{
				return JError::raiseWarning(500, $row->getError());
			}

			// All is done clear sessiondata to prevent double saved data
			$this->clearSession();

			/*
			 * wir senden nun noch eine Email zur Benachrichtigung der Administration
			 * der rueckgabewert ist fuer den Besucher nicht interessant und wird verworfen
			 */
			$this->sendNotifyEmail($row);

			return true;
		}
		else
		{
			if ($this->getUserState('hereweare') != '')
			{
				die('---> check failed <---');
			}
			return true;
		}
	}

	/**
	 * get geo coordinate
	 *
	 * @return string message
	 */
	public function getGeoCoordinate()
	{
		$msg = '';
		$fconf = $this->params;
		$confvar = $fconf->get('showlocation', 2);

		if ($confvar == 5)
		{
			$street = $this->getUserState('street');
			$pcode = $this->getUserState('pcode');
			$city = $this->getUserState('city');

			$gm = BabioonGooglemaps::getInstance();

			$result = $gm->getGeoKoordinaten($street, $pcode, $city);

			if ($result !== false)
			{
				$this->setUserState('geo_l', $result[0]);
				$this->setUserState('geo_b', $result[1]);
				$msg = 'COM_BABIOONEVENT_GEOOK';
			}
			else
			{
				$msg = 'COM_BABIOONEVENT_GEOFAIL';
			}
		}

		return $msg;
	}

	/**
	 * getGeoCoordinateIfNecessary
	 *
	 * @param   object  $row  the data
	 *
	 * @return  int
	 */
	public function getGeoCoordinateIfNecessary($row)
	{
		$rvalue = 2;
		$fconf = $this->params;
		$confvar = $fconf->get('showlocation', 2);

		if ($confvar == 5)
		{
			$street = $this->getUserState('street');
			$pcode = $this->getUserState('pcode');
			$city = $this->getUserState('city');

			if (!($street == $row->street && $pcode == $row->pcode && $city == $row->city && $row->geo_b != 0 && $row->geo_b != 0))
			{
				$gm = BabioonGooglemaps::getInstance();
				$result = $gm->getGeoKoordinaten($street, $pcode, $city);

				if ($result !== false)
				{
					$this->setUserState('geo_l', $result[0]);
					$this->setUserState('geo_b', $result[1]);
					$rvalue = 1;
				}
			}
			else
			{
				$rvalue = 0;
			}
		}
		return $rvalue;
	}

	/**
	 * Get the category list
	 *
	 * @return array of objects
	 */
	public function getCategoryList()
	{
		$option = JHtml::_('category.categories', 'com_babioonevent');

		// Eliminate "add to root"
		array_pop($option);

		// All categories should be selected by default
		$seleccted = array();

		foreach ($option as $key => $value)
		{
			$seleccted[] = $value->value;
		}

		return JHtml::_('select.genericlist', $option, 'excatid[]', ' multiple="multiple" size="10"', 'value', 'text', $seleccted);
	}

	/**
	 * Get the category name
	 *
	 * @return string
	 */
	public function getCategoryName()
	{
		$db    = $this->getDbo();
		$catid = $this->getUserState('catid');
		$query = "SELECT title FROM #__categories WHERE id = '$catid' ";
		$db->setQuery($query);

		return $db->loadResult();
	}

	/**
	 * clear session data
	 *
	 * @param   string  $type  the type
	 *
	 * @return  void
	 */
	public function clearSession($type='default')
	{
		$form		= $this->getForm($type);

		foreach ($form as $elm)
		{
			$this->setUserState($elm['name'], '');
		}
		$this->setUserState('hereweare', '');
		$this->setUserState('geo_l', '');
		$this->setUserState('geo_b', '');
	}

	/**
	 * send a notifcation about a new event
	 *
	 * @param   object  $row  information
	 *
	 * @return void
	 */
	private function sendNotifyEmail($row)
	{
		$fromname = $this->params->get('emailfrom');

		if ($fromname == 'Event')
		{
			$fromname = '';
		}
		$from = $this->params->get('email');

		if ($from == 'info@mail.org')
		{
			$from = '';
		}
		$email = $this->params->get('emailsendto');
		$email = str_replace(';', ',', $email);

		if (strpos($email, ',') !== false)
		{
			$email = explode(',', $email);
		}

		$uri     = JURI::getInstance();
		$link    = $uri->base() . 'index.php';
		$body    = JText::sprintf('COM_BABIOONEVENT_NOTIFYEMAILTXT', $link);
		$subject = JText::_($row->name);
		$mail    = JFactory::getMailer();

		if (!$mail->sendMail($from, $fromname, $email, $subject, $body, 1))
		{
			return false;
		}
		return true;
	}
	/**
	 * set the user state as session var
	 *
	 * @param   string  $key    key
	 * @param   mixed   $value  value
	 *
	 * @return  void
	 */
	public function setUserState($key, $value)
	{
		return JFactory::getApplication('site')->setUserState($this->_context . '.' . $key, $value);
	}
	/**
	 * get a user state from the session
	 *
	 * @param   string  $key      key
	 * @param   mixed   $default  default value
	 *
	 * @return  mixed
	 */
	public function getUserState($key, $default = null)
	{
		return JFactory::getApplication('site')->getUserState($this->_context . '.' . $key, $default);
	}
	/**
	 * get user state from request or session
	 *
	 * @param   string  $key      key
	 * @param   mixed   $default  default value
	 * @param   string  $type     request area
	 *
	 * @return  mixed
	 */
	public function getUserStateFromRequest($key, $default = null, $type = 'none')
	{
		return JFactory::getApplication('site')->getUserStateFromRequest($this->_context . '.' . $key, $key, $default, $type);
	}
}
