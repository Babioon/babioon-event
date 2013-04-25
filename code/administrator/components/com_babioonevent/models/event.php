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

jimport('joomla.application.component.modeladmin');

/**
 * model address.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventModelEvent extends JModelAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_BABIOONEVENT_';

	protected $index = array();

	/**
	 * Returns a JTable object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate. [optional]
	 * @param   string  $prefix  A prefix for the table class name. [optional]
	 * @param   array   $config  Configuration array for model. [optional]
	 *
	 * @return  JTable  A database object
	 */
	public function getTable($type = 'Event', $prefix = 'BabioonEventTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form. [optional]
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_babioonevent.event', 'event', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		/*
		 * modify fields on the fly
		 */
		/*
		$form->setFieldAttribute('name', 'required', false);
		$form->setFieldAttribute('name', 'class', 'inputbox');
		*/
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_babioonevent.edit.event.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		if ($data->stimeset == 1)
		{
			// Split the start and time field
			$data->stimehh = substr($data->stime, 0, 2);
			$data->stimemm = substr($data->stime, 3, 2);
		}
		else
		{
			$data->stimehh = '';
			$data->stimemm = '';
		}

		if ($data->etimeset == 1)
		{
			// Split the start and time field
			$data->etimehh = substr($data->etime, 0, 2);
			$data->etimemm = substr($data->etime, 3, 2);
		}
		else
		{
			$data->etimehh = '';
			$data->etimemm = '';
		}

		return $data;
	}

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param   JTable  &$table  A JTable object.
	 *
	 * @return	void
	 */
	protected function prepareTable(&$table)
	{
		// We need the input
		$data = JFactory::getApplication()->input->get('jform', array(), 'post', 'array');

		$stimehh = $data['stimehh'];
		$stimemm = $data['stimemm'];

		// Merge start and end time
		if ($stimehh != '')
		{
			if ($stimemm == '')
			{
				$stimemm = '00';
			}
			$table->stime = $stimehh . ':' . $stimemm . ':00';
			$table->stimeset = 1;
		}
		else
		{
			$table->stime = '00:00:00';
			$table->stimeset = 0;
		}

		$etimehh = $data['etimehh'];
		$etimemm = $data['etimemm'];

		if ($etimehh != '')
		{
			if ($etimemm == '')
			{
				$etimemm = '00';
			}
			$table->etime = $etimehh . ':' . $etimemm . ':00';
			$table->etimeset = 1;
		}
		else
		{
			$table->etime = '00:00:00';
			$table->etimeset = 0;
		}
	}
}
