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
class BabiooneventControllerEvent extends FOFController
{
	/**
	 * change task, this runs when a user click on change value in the preview
	 * layout. It shows the form without cleaning the values
	 *
	 * @return  mixed  true on sucess, exeception if something goes wrong
	 */
	public function change()
	{
		$model = $this->getThisModel();

		// Set the layout
		$this->layout = 'form';

		// We still use the same form
		$model->setState('form_name', 'form.form');

		$data = JFactory::getApplication()->getUserState('com_babioonevent.events');

		// Check userState for stime
		$stimeset = $data->stimeset;

		if ($stimeset == 1)
		{
			$stime = $data->stime;
			list($stimehh, $stimemm) = explode(":", $stime);
			$data->stimehh = $stimehh;
			$data->stimemm = $stimemm;
		}
		else
		{
			$data->stimehh = '--';
			$data->stimemm = '--';
		}

		// Check userState for etime
		$etimeset = $data->etimeset;

		if ($etimeset == 1)
		{
			$etime = $data->etime;
			list($etimehh, $etimemm) = explode(":", $etime);
			$data->etimehh = $etimehh;
			$data->etimemm = $etimemm;
		}
		else
		{
			$data->etimehh = '--';
			$data->etimemm = '--';
		}

		$form = $model->getForm($data);

		if ($form !== false)
		{
			$this->hasForm = true;
		}

		// Display
		$this->display();

		return true;
	}

	/**
	 * preview task, this is called for the add event form, checks values and redirect
	 * back to the form if validate failed or show the preview layout if everthing is
	 * fine
	 *
	 * @return  mixed  true on sucess, exeception if something goes wrong
	 */
	public function preview()
	{
		$model = $this->getThisModel();

		// We still use the same form
		$model->setState('form_name', 'form.form');

		$data = $this->input->getData();

		$dtFields = array('s','e');

		foreach ($dtFields as $dtf)
		{
			// Preset default values
			JFactory::getApplication()->setUserState('com_babioonevent.events.' . $dtf . 'time', '00:00:00');
			JFactory::getApplication()->setUserState('com_babioonevent.events.' . $dtf . 'timeset', '0');

			// Check time and date
			$result = $model->checkDate($dtf . 'date');

			if ($result !== false)
			{
				$data[$dtf . 'date'] = $result;
				$result = $model->checkTime($dtf . 'time');

				if ($result !== false)
				{
					$data[$dtf . 'time'] = $result;
					$data[$dtf . 'timeset'] = 1;

					// Set the time as  Userstate we need that later, don't ask me why it is not saved automatic
					JFactory::getApplication()->setUserState('com_babioonevent.events.' . $dtf . 'time', $result);
					JFactory::getApplication()->setUserState('com_babioonevent.events.' . $dtf . 'timeset', '1');
				}
			}
		}

		// Get the form
		$form = $model->getForm($data);

		if ($form !== false)
		{
			$this->hasForm = true;
		}

		// Set the layout
		$this->layout = 'preview';

		if ($model->validateForm($form, $data) === false)
		{
			$this->layout = 'form';
		}
		else
		{
			if ($model->getGeoCoordinates($data))
			{
				if (array_key_exists('geo_l', $data))
				{
					JFactory::getApplication()->setUserState('com_babioonevent.events.geo_l', $data['geo_l']);
				}

				if (array_key_exists('geo_b', $data))
				{
					JFactory::getApplication()->setUserState('com_babioonevent.events.geo_l', $data['geo_b']);
				}
			}
		}

		// Display
		$this->display();

		return true;
	}

	/**
	 * Show the export result task
	 *
	 * @return  boolean true
	 */
	public function eresult()
	{
		$model = $this->getThisModel();
		$check = $model->validateExportForm();

		if ($check)
		{
			// Set the layout
			$this->layout = 'eresult';
		}
		else
		{
			// Set the layout
			$this->layout = 'export';

			$model->setState('form_name', 'form.' . $this->layout);

			$data = $this->input->getData();
			$form = $model->getForm($data);

			if ($form !== false)
			{
				$this->hasForm = true;
			}
		}

		// Display
		$this->display();

		return true;
	}

	/**
	 * the search result task
	 *
	 * @return  boolean true
	 */
	public function sresult()
	{
		$model = $this->getThisModel();

		// Set the layout
		$this->layout = 'sresult';

		$model = $this->getThisModel();
		$model->resetSavedState();
		$model->setState('filter_order', 'sdate');
		$model->setState('filter_order_Dir', 'ASC');

		$params = JComponentHelper::getParams('com_babioonevent');
		$model->setState('limit', $params->get('defaultlistlength', 25));

		// Display
		$this->display();

		return true;
	}

	/**
	 * [onBeforeBrowse description]
	 *
	 * @return  [type]  [description]
	 */
	protected function onBeforeBrowse()
	{
		$model = $this->getThisModel();
		$model->resetSavedState();
		$model->setState('filter_order', 'sdate');
		$model->setState('filter_order_Dir', 'ASC');

		$params = JComponentHelper::getParams('com_babioonevent');
		$model->setState('limit', $params->get('defaultlistlength', 25));

		return true;
	}

	/**
	 * graps data out of the session and changed the data array so it get saved
	 *
	 * @param   array  &$data  the data
	 *
	 * @return  boolean  true on success
	 */
	protected function onBeforeApplySave(&$data)
	{
		$data = JFactory::getApplication()->getUserState('com_babioonevent.events');

		return true;
	}

	/**
	 * onAfterSave redirects after save to the thank you page
	 *
	 * @return  mixed  true on sucess, exeception if something goes wrong
	 */
	protected function onAfterSave()
	{
		$model = $this->getThisModel();
		$model->resetSavedState();

		$Itemid = BabioonEventRouteHelper::getItemid('event');
		$this->setRedirect('index.php?option=com_babioonevent&view=thankyou&Itemid=' . $Itemid);

		return true;
	}
}
