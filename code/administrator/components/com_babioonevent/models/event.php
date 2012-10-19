<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * model address.
 *
 * @package     BABIOON_EVENT
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
	 *
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
		//$form->setFieldAttribute('name','required', false);
		//$form->setFieldAttribute('name','class','inputbox');
		
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
		// split the start and time field 	
		$data->stimehh = substr($data->stime, 0,2);
		$data->stimemm = substr($data->stime, 3,2);

		$data->etimehh = substr($data->etime, 0,2);
		$data->etimemm = substr($data->etime, 3,2);

		return $data;
	}

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param	JTable	A JTable object.
	 *
	 * @return	void
	 */
	protected function prepareTable(&$table)
	{
		// merge start and end time
		if ($table->stimmhh != '')
		{
			if ($table->stimemm == '')
			{
				$table->stimemm = '00';
			}	
			$table->stime = $table->stimmhh.':'.$table->stimemm.':00';
			$table->stimeset = 1;
			unset ($table->stimmhh);
			unset ($table->stimmmm);	
		}	

		if ($table->etimmhh != '')
		{
			if ($table->etimemm == '')
			{
				$table->etimemm = '00';
			}	
			$table->etime = $table->etimmhh.':'.$table->etimemm.':00';
			$table->etimeset = 1;
			unset ($table->etimmhh);
			unset ($table->etimmmm);	
		}	
	}
}