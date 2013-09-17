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
 * model event
 *
 * @package  BABIOON_EVENT
 * @since    3.0
 */
class BabiooneventModelEvents extends FOFModel
{
	/**
	 * the query data
	 *
	 * @var  array
	 */
	protected $data = array();

	/**
	 * This method runs before the $data is saved to the $table. Return false to
	 * stop saving.
	 *
	 * @param   array     &$data   The data to save
	 * @param   FOFTable  &$table  The table to save the data to
	 *
	 * @return  boolean  Return false to prevent saving, true to allow it
	 */
	protected function onBeforeSave(&$data, &$table)
	{
		if (!parent::onBeforeSave($data, $table))
		{
			return false;
		}

		$isAdmin = FOFPlatform::getInstance()->isBackend();

		if (!$isAdmin)
		{
			$data['enabled'] = 0;
		}
		else
		{
			if ($this->getGeoCoordinates($data) === false)
			{
				$this->setError(JText::_('COM_BABIOONEVENT_GET_GEOCOORDINATES_FAILED'));

				return false;
			}

			$dtFields = array('s','e');

			foreach ($dtFields as $dtf)
			{
				// Preset default values
				$data[$dtf . 'time'] = '00:00:00';
				$data[$dtf . 'timeset'] = '0';

				// Check time and date
				$result = $this->checkDate($dtf . 'date');

				if ($result !== false)
				{
					$data[$dtf . 'date'] = $result;
					$result = $this->checkTime($dtf . 'time');

					if ($result !== false)
					{
						$data[$dtf . 'time'] = $result;
						$data[$dtf . 'timeset'] = 1;
					}
				}
			}
		}

		if ($this->_isNewRecord)
		{
			$data['created'] = JFactory::getDate()->toSql();

			if ($isAdmin)
			{
				$data['created_by'] 		= JFactory::getUser()->get('id');
				$data['created_by_alias'] 	= JFactory::getUser()->get('name');
			}
			else
			{
				$data['created_by'] 		= 0;
				$data['created_by_alias'] 	= 'WebsiteForm';
			}
		}
		else
		{
			if ($isAdmin)
			{
				$data['modified'] 		= JFactory::getDate()->toSql();
				$data['modified_by'] 	= JFactory::getUser()->get('id');
			}
			else
			{
				// Confused
				return false;
			}
		}

		$params = JComponentHelper::getParams('com_babioonevent');

		if ($params->get('showcategory', 1) == 0)
		{
			$defaultcategory = $params->get('defaultcategory', 0);

			if ($defaultcategory != 0)
			{
				$data['catid'] = $defaultcategory;
			}
		}

		// Make sure the dates have the correct format

		foreach (array ('sdate', 'edate') as $d)
		{
			if ($data[$d] != '')
			{
				$data[$d] = $this->formatDate($data[$d]);

				if ($data[$d] === false)
				{
					$this->setError('Date format not valid: ' . $d);

					return false;
				}
			}
		}

		return true;
	}

	/**
	 * This method runs after an item has been gotten from the database in a read
	 * operation. You can modify it before it's returned to the MVC triad for
	 * further processing.
	 *
	 * @param   FOFTable  &$record  The table instance we fetched
	 *
	 * @return  void
	 */
	protected function onAfterGetItem(&$record)
	{
		parent::onAfterGetItem($record);

		if ($record->sdate == '0000-00-00')
		{
			$record->sdate = '';
		}

		if ($record->edate == '0000-00-00')
		{
			$record->edate = '';
		}

		if (strpos($record->sdate, '-') !== false)
		{
			list($y, $m, $d) = explode('-', $record->sdate);
			$record->sdate = $d . '.' . $m . '.' . $y;
		}

		if (strpos($record->edate, '-') !== false)
		{
			list($y, $m, $d) = explode('-', $record->edate);
			$record->edate = $d . '.' . $m . '.' . $y;
		}

		if ($record->stimeset == 1)
		{
			list($stimehh, $stimemm) = explode(":", $record->stime);
			$record->stimehh = (int) $stimehh;
			$record->stimemm = (int) $stimemm;
		}

		if ($record->etimeset == 1)
		{
			list($etimehh, $etimemm) = explode(":", $record->etime);
			$record->etimehh = (int) $etimehh;
			$record->etimemm = (int) $etimemm;
		}
	}

	/**
	 * ajust the query
	 *
	 * @param   boolean  $overrideLimits  Are we requested to override the set limits?
	 *
	 * @return  JDatabaseQuery
	 */
	public function buildQuery($overrideLimits = false)
	{
		// We don't do the next statement because it is doin some crazy stuff with filters
		$query = parent::buildQuery($overrideLimits);

		$db    = $this->getDbo();

		$formName = $this->getState('form_name');
		$task = $this->getState('task');

		if ($formName == 'form.default' || (is_null($formName) && $task == 'sresult'))
		{
			if (FOFPlatform::getInstance()->isFrontend())
			{
				$query->where($db->qn('enabled') . ' = 1');

				if ($formName == 'form.default')
				{
					$now   = JFactory::getDate()->format("Y-m-d");
					$query->where($db->qn('sdate') . ' >= ' . "'$now'");
				}
				else
				{
					$isfreeofcharge = $this->input->get('s_isfreeofcharge', 0);

					if ($isfreeofcharge == 1)
					{
						$query->where($db->qn('isfreeofcharge') . ' = 1');
					}

					$sdate = $this->input->get('s_sdate');

					if ($sdate == '')
					{
						$sdate   = JFactory::getDate()->format("Y-m-d");
					}
					else
					{
						$sdate = $this->formatDate($sdate);
					}

					$query->where($db->qn('sdate') . ' >= ' . $db->q($sdate));

					$edate = $this->input->get('s_edate');

					if ($edate != '')
					{
						$query->where($db->qn('edate') . ' <= ' . $db->q($edate));
					}
					else
					{
						$edate = $this->formatDate($edate);
					}

					$pcodefrom = $this->input->get('pcodefrom');

					if ($pcodefrom != '')
					{
						$query->where($db->qn('pcode') . ' >= ' . $db->q($pcodefrom));
					}

					$pcodeupto = $this->input->get('pcodeupto');

					if ($pcodeupto != '')
					{
						$query->where($db->qn('pcode') . ' <= ' . $db->q($pcodeupto));
					}

					$fulltext = $this->input->get('fulltext', '', 'string');

					if ($fulltext != '')
					{
						$fulltext = '%' . $fulltext . '%';
						$query->where('(' .
									$db->qn('name') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('organiser') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('contact') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('ainfo') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('street') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('pcode') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('city') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('state') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('country') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('teaser') . ' like ' . $db->q($fulltext) . ') OR (' .
									$db->qn('text') . ' like ' . $db->q($fulltext) . ')'
									);
					}

					$excatid 	= (array) $this->input->get('excatid');
					JArrayHelper::toInteger($excatid);
					$excatid 	= implode(',', $excatid);
					$query->where($db->qn('catid') . ' IN ' . '(' . $excatid . ')');
				}
			}
		}

		return $query;
	}

	/**
	 * Method to get a list of items.
	 *
	 * @param   boolean  $overrideLimits  Should I override set limits?
	 * @param   string   $group           The group by clause
	 *
	 * @return  array
	 */
	public function &getItemList($overrideLimits = false, $group = '')
	{
		$items	= parent::getItemList($overrideLimits, $group);

		if (FOFPlatform::getInstance()->isFrontend())
		{
			$Itemid = BabioonEventRouteHelper::getItemid();
			$link = 'index.php?option=com_babioonevent&view=event&layout=item&Itemid=' . $Itemid . '&id=';

			for ($i = 0,$ccount = count($items);$i < $ccount;$i++)
			{
				$items[$i]->link = $link . $items[$i]->babioonevent_event_id;
			}
		}

		return $items;
	}

	/**
	 * Allows the manipulation before the form is loaded
	 *
	 * @param   string  &$name     The name of the form.
	 * @param   string  &$source   The form source. Can be XML string if file flag is set to false.
	 * @param   array   &$options  Optional array of options for the form creation.
	 *
	 * @return  void
	 */
	public function onBeforeLoadForm(&$name, &$source, &$options)
	{
		if ($source == 'form.item')
		{
			$source = 'form.form';
			$this->setState('form_name', $source);
		}

		/*
		 *	this is a total strange way to set a default value for a field, but after hours of debugging
		 *	I was sick of looking for a more elegant way and used a hammer, boom!
		 */
		$task = $this->getState('task');

		if ($task == 'add')
		{
			if (is_array($this->_formData) && array_key_exists('isfreeofcharge', $this->_formData))
			{
				$this->_formData['isfreeofcharge'] = '1';
			}
		}
	}

	/**
	 * Allows the manipulation before the form is loaded
	 *
	 * @param   string  &$data  The data
	 *
	 * @return  boolean         false is something was wrong, otherwise true
	 */
	public function getGeoCoordinates(&$data)
	{
		$params  = JComponentHelper::getParams('com_babioonevent');
		$isAdmin = FOFPlatform::getInstance()->isBackend();

		if ($params->get('showlocation', 2) == 5)
		{
			// Do we need to figure out the googlemaps coordinates?
			if (($params->get('getgeo', 1) == 1 && $isAdmin) || ($params->get('getgeo', 1) == 2))
			{
				if (!class_exists('BabioonGooglemapsV3Helper', false))
				{
					require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/babioongooglemapsv3.php';
				}

				$gmmaps   = new BabioonGooglemapsV3Helper;
				$gmresult = $gmmaps->getGeoCoordinates($data['street'], $data['pcode'], $data['city'], $data['state'], $data['country']);

				if ($gmresult !== false)
				{
					list($data['geo_l'], $data['geo_b']) = $gmresult;

					return true;
				}

				return false;
			}
		}

		return true;
	}

	/**
	 * Method to allow derived classes to preprocess the form.
	 *
	 * @param   FOFForm  $form   A FOFForm object.
	 * @param   mixed    &$data  The data expected for the form.
	 * @param   string   $group  The name of the plugin group to import (defaults to "content").
	 *
	 * @return  void
	 *
	 * @see     FOFFormField
	 * @since   2.0
	 * @throws  Exception if there is an error in the form event.
	 */
	protected function preprocessForm(FOFForm $form, &$data, $group = 'content')
	{
		// Do what have to be done
		parent::preprocessForm($form, $data, $group);

		$formName = $this->getState('form_name');

		if ($formName == 'form.form' ||$formName == 'form.item')
		{
			$isAdmin = FOFPlatform::getInstance()->isBackend();
			$params = JComponentHelper::getParams('com_babioonevent');

			// Handele enabled field access
			if (!$isAdmin || ($this->input->getCmd('task') == 'edit' && !$isAdmin))
			{
				$this->removeFields($form, 'enabled');
			}

			// Handle the date and time fields
			$showdates = $params->get('showdates', 4);
			$remove    = array('stimehh','stimemm','edate','etimehh','etimemm');
			$required  = array();

			if (!in_array($showdates, array(1,3,6,9,14)))
			{
				$offset = array_search('stimehh', $remove);
				array_splice($remove, array_search('stimehh', $remove), 1);
				array_splice($remove, array_search('stimemm', $remove), 1);
			}

			if ($showdates > 5)
			{
				array_splice($remove, array_search('edate', $remove), 1);
			}

			if (in_array($showdates, array(8,12,13,17,18,19)))
			{
				array_splice($remove, array_search('etimehh', $remove), 1);
				array_splice($remove, array_search('etimemm', $remove), 1);
			}

			if (in_array($showdates, array(3,4,5)) || $showdates > 8)
			{
				$required[] = 'sdate';
			}

			if (in_array($showdates, array(5,11,13,16,18,19)))
			{
				$required[] = 'stimehh';
				$required[] = 'stimemm';
			}

			if ($showdates > 13)
			{
				$required[] = 'edate';
			}

			if ($showdates == 19)
			{
				$required[] = 'etimehh';
				$required[] = 'etimemm';
			}

			$this->removeFields($form, $remove);
			$this->setFieldsRequired($form, $required);

			$fields = array('organiser' => 2,
							'contact' 	=> 1,
							'phone' 	=> 1,
							'website' 	=> 1,
							'email' 	=> 1,
							'shortdesc' => 1,
							'longdesc' 	=> 1
							);

			foreach ($fields AS $fieldname => $defaultvalue)
			{
				$this->manageField($form, $fieldname, $params->get('show' . $fieldname, $defaultvalue));
			}

			// Remove checkbox showemail when email is disabled
			if ($params->get('showemail', 1) == 0)
			{
				$this->removeFields($form, 'showemail');
			}

			// Change editor to textbox when frontend
			if (!$isAdmin)
			{
				$form->setFieldAttribute('teaser', 'type', 'textarea');
				$form->setFieldAttribute('text', 'type', 'textarea');
			}

			// Location fields
			$showlocation = $params->get('showlocation', 2);
			$locDetails = array('ainfo','street','pcode','city','state','country');

			if ($showlocation == 0)
			{
				$this->removeFields($form, 'address');

				foreach ($locDetails as $field)
				{
					$this->removeFields($form, $locDetails);
				}
			}
			else
			{
				if ($showlocation > 2)
				{
					$this->removeFields($form, 'address');

					if ($showlocation > 3)
					{
						$this->setFieldsRequired($form, array_slice($locDetails, 1));
					}
				}
				else
				{
					$this->removeFields($form, $locDetails);

					if ($showlocation == 2)
					{
						$this->setFieldsRequired($form, 'address');
					}
				}
			}

			// Manage charge fields
			if ($params->get('showcharge', 2) == 0)
			{
				$this->removeFields($form, 'isfreeofcharge');
				$form->setFieldAttribute('charge', 'required', 'false');
				$this->removeFields($form, 'charge');
			}

			$defaultcategory = $params->get('defaultcategory', 0);

			// Remove category field when always standard category
			if ($params->get('showcategory', 1) == 0)
			{
				// We remove it only when we have a default category
				if ($defaultcategory != 0)
				{
					$this->removeFields($form, 'catid');
				}
			}
			else
			{
				if ($defaultcategory != 0)
				{
					$form->setFieldAttribute('catid', 'default', $defaultcategory);
				}
			}
		}
	}

	/**
	 * Method to validate the form data.
	 *
	 * @param   FOFForm  $form   The form to validate against.
	 * @param   array    $data   The data to validate.
	 * @param   string   $group  The name of the field group to validate.
	 *
	 * @return  mixed   Array of filtered data if valid, false otherwise.
	 *
	 * @see     JFormRule
	 * @see     JFilterInput
	 * @since   2.0
	 */
	public function validateForm($form, $data, $group = null)
	{
		$params = JComponentHelper::getParams('com_babioonevent');
		$validateIsfreeofcharge = $params->get('showcharge', 2);

		if ($validateIsfreeofcharge == 2)
		{
			// Set charge to required to true when isfreeofcharge == 0
			$isfreeofcharge = is_object($data) ? $data->isfreeofcharge : $data['isfreeofcharge'];

			if ($isfreeofcharge == 0)
			{
				$form->setFieldAttribute('charge', 'required', 'true');
			}
		}

		$result = parent::validateForm($form, $data, $group);

		if ($validateIsfreeofcharge == 2)
		{
			if ($isfreeofcharge == 0)
			{
				$form->setFieldAttribute('charge', 'required', 'false');
			}
		}

		return $result;
	}

	/**
	 * validate the date we got from the user
	 *
	 * @return  boolean  true is data are valid, false otherwise
	 */
	public function validateExportForm()
	{
		// We do some easy sanity checks to give the user a bit of advice
		$errors = array();

		$sdateVaild = $this->checkDate('sdate') !== false;
		$edateVaild = $this->checkDate('edate') !== false;

		if ($sdateVaild && $edateVaild)
		{
			if ($this->input->get('edate') < $this->input->get('sdate'))
			{
				$errors[] = JText::_('COM_BABIOONEVENT_EXPORT_ORDERDATES_ERRORMSG');
			}
		}

		if (!$sdateVaild)
		{
			$errors[] = JText::_('COM_BABIOONEVENT_EXPORT_SDATE_ERRORMSG');
		}

		if (!$edateVaild)
		{
			// Remove crap
			$this->input->set('edata', '');
		}

		$excatid = $this->input->get('excatid');

		if (empty($excatid))
		{
			// At least we need one Category
			$errors[] = JText::_('COM_BABIOONEVENT_EXPORT_EXCATID_ERRORMSG');
		}

		if (!empty($errors))
		{
			foreach ($errors as $message)
			{
				$this->setError($message);
			}

			return false;
		}

		return true;
	}

	/**
	 * Manage a field depending on a configuration value
	 *
	 * @param   FOFForm  $form       A form object
	 * @param   string   $fieldname  The fieldname
	 * @param   int      $confvalue  The configuration value
	 *
	 * @return  void
	 */
	private function manageField($form, $fieldname, $confvalue)
	{
		if ($confvalue == 0)
		{
			$this->removeFields($form, $fieldname);
		}
		elseif ($confvalue == 2)
		{
			$this->setFieldsRequired($form, $fieldname);
		}
	}

	/**
	 * Set a field to be a requiered field
	 *
	 * @param   FOFForm  $form    A form object
	 * @param   mixed    $fields  Array of fieldnames or a fieldname
	 *
	 * @return  void
	 */
	private function setFieldsRequired($form, $fields)
	{
		$fields = (array) $fields;

		foreach ($fields as $fieldname)
		{
			$form->setFieldAttribute($fieldname, 'required', 'true');
		}
	}

	/**
	 * remove a field
	 *
	 * @param   FOFForm  $form    A form object
	 * @param   mixed    $fields  Array of fieldnames or a fieldname
	 *
	 * @return  void
	 */
	private function removeFields($form, $fields)
	{
		$fields = (array) $fields;

		foreach ($fields as $fieldname)
		{
			$form->removeField($fieldname);
		}
	}

	/**
	 * checks if a Date is valid
	 *
	 * @param   string  $what  what date type
	 *
	 * @return  string         the date on sucess or false on fail
	 */
	public function checkDate($what='sdate')
	{
		$result	= trim($this->input->get($what));

		if ($result != '')
		{
			$datesplited = explode('.', $result);

			if (checkdate($datesplited[1], $datesplited[0], $datesplited[2]))
			{
				return $result;
			}
		}

		return false;
	}

	/**
	 * checks if a time is valid
	 *
	 * @param   string  $what  what date type
	 *
	 * @return  string         the time on sucess or false on fail
	 */
	public function checkTime($what='stime')
	{
		$result = false;
		$hh 	= trim($this->input->get($what . 'hh', '--'));
		$mm 	= trim($this->input->get($what . 'mm', '--'));

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
	 * format a date so that it can be used in queries
	 *
	 * @param   string  $date    the date
	 * @param   string  $format  the source format
	 *
	 * @return  string         the date or false
	 */
	public function formatDate($date, $format='auto')
	{
		if ($format == 'auto')
		{
			// Guessing the source format
			if (strpos($date, '.'))
			{
				// Guess it is DAY.MONTH.YEAR
				list($d, $m, $y) = explode('.', $date);

				return $y . '-' . $m . '-' . $d;
			}

			if (strpos($date, '-'))
			{
				// Guess it is YEAR-MONTH-DAY
				return $date;
			}
		}
		else
		{
			$ndate = date_create_from_format($format, $date);

			if ($ndate === false)
			{
				return false;
			}

			return date_format($ndate, 'Y-m-d');
		}

		return false;
	}

	/**
	 * get the export data based on the given values
	 *
	 * @return array
	 */
	public function getExportData()
	{
		$params 	= JComponentHelper::getParams('com_babioonevent');
		$db 		= $this->getDbo();

		$sdate 		= $this->input->get('sdate');
		$edate 		= $this->input->get('edate');
		$excatid 	= (array) $this->input->get('excatid');
		JArrayHelper::toInteger($excatid);
		$excatid 	= implode(',', $excatid);

		$query = $db->getQuery(true);

		$query->where($db->qn('e.catid') . ' = cc.id')
				->where($db->qn('e.enabled') . ' = 1')
				->where($db->qn('cc.published') . ' = 1')
				->where($db->qn('e.catid') . ' in ( ' . $excatid . ')');

		if (!empty($sdate))
		{
			$sdate = $this->formatDate($sdate);
			$query->where($db->qn('e.sdate') . ' >= ' . $db->q($sdate));
		}

		if (!empty($edate))
		{
			$edate = $this->formatDate($edate);
			$query->where($db->qn('e.edate') . ' <= ' . $db->q($edate));
			$query->where($db->qn('e.sdate') . ' < ' . $db->q($edate));
		}

		$farray		= array();
		$fields  = array('organiser','start','end','contact','email','tel','website','address','teaser','text','isfreeofcharge','charge');

		foreach ($fields as $elm)
		{
			if ($params->get('export' . $elm) == 1)
			{
				switch ($elm)
				{
					case 'start':
						$query->select('IF(stimeset = 1, CONCAT(e.sdate," ",e.stime), e.sdate) AS start');
						break;
					case 'end':
						$query->select('IF(etimeset = 1, CONCAT(e.edate," ",e.etime), e.edate) AS end');
						break;
					case 'address':
						// Separate field, if empty is in old entry
						$query->select('IF(street <> "",CONCAT(IF(ainfo<>"",CONCAT(ainfo,", "),""),street,IF(pcode<>"",CONCAT(", ",pcode),""),IF(city<>"",CONCAT(" ",city),"") ),address) AS address');
						break;
					default:
						$query->select('e.' . $elm);
						break;
				}
			}
		}

		$query->select("e.stimeset")
				->select("e.etimeset")
				->select("e.showemail")
				->select("e.name ")
				->select("cc.title as cctitle")
				->from("#__babioonevent_events as e")
				->from("#__categories as cc")
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
		$params 		= JComponentHelper::getParams('com_babioonevent');
		$exportfiles 	= $params->get('exportfiles', 1);

		if ($exportfiles == 0)
		{
			// Do nothing but return the correct valuetype
			return array('','');
		}

		$filename	= false;
		$filename2	= false;
		$this->getExportData();
		$cr = count($this->data);

		if ($cr != 0)
		{
			// Rel dir to siteroot
			$exportdir = $params->get('exportdir');
			$glue = $params->get('exportglue', ';');
			$quote = $params->get('exportquote', 0);
			$codepage = $params->get('export_codepage', 1);

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

			$adir = JPATH_ROOT . '/' . $exportdir;

			if ($exportfiles == 1 || $exportfiles == 3)
			{
				$filename = BabioonEventHelper::getFilename($adir, 'export', 'csv');
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
							$r['start'] = date($params->get('sformat', 'd.m.Y H:i'), strtotime($r['start']));
						}
						else
						{
							$r['start'] = date($params->get('sformat', 'd.m.Y'), strtotime($r['start']));
						}
					}

					if (in_array('end', $head_fields))
					{
						if ($r['etimeset'] == 1)
						{
							$r['end'] = date($params->get('sformat', 'd.m.Y H:i'), strtotime($r['end']));
						}
						else
						{
							if ($r['end'] == '0000-00-00')
							{
								$r['end'] = '';
							}
							else
							{
								$r['end'] = date($params->get('sformat', 'd.m.Y'), strtotime($r['end']));
							}
						}
					}

					if (in_array('isfreeofcharge', $head_fields))
					{
						$r['isfreeofcharge'] = $r['isfreeofcharge'] ? JText::_('JYES') : JText::_('JNO');
					}

					if (in_array('address', $head_fields))
					{
						$r['address'] = BabioonEventHelper::html2txt($r['address']);
					}

					if (in_array('teaser', $head_fields))
					{
						$r['teaser'] = BabioonEventHelper::html2txt($r['teaser']);
					}

					if (in_array('text', $head_fields))
					{
						$r['text'] = BabioonEventHelper::html2txt($r['text']);
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

				$handle = fopen(JPATH_ROOT . '/' . $exportdir . '/' . $filename, 'w+');
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
				$filename = $exportdir . '/' . $filename;

				if (DIRECTORY_SEPARATOR != '/')
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
				$filename2 = BabioonEventHelper::getFilename($adir, 'export', 'txt');
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
						$text .= trim(BabioonEventHelper::html2txt($r['address']), '"');
						$text .= "\n";
					}

					if (in_array('organiser', $head_fields))
					{
						$text .= trim(BabioonEventHelper::html2txt($r['organiser']), '"');
						$text .= "\n";
					}

					$txt[] = $text;
				}

				$handle = fopen(JPATH_ROOT . '/' . $exportdir . '/' . $filename2, 'w+');

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
				$filename2 = $exportdir . '/' . $filename2;

				if (DIRECTORY_SEPARATOR != '/')
				{
					$filename2 = str_replace('\\', '/', $filename2);
				}

				$result[] = $filename2;
			}
			else
			{
				$result[] = '';
			}

			return $result;
		}

		return array('','');
	}
}
