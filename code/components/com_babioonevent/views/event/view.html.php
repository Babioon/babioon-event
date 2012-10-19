<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__).'/../object.html.php';

/**
 * BabioonEventViewEvent
 */
class BabioonEventViewEvent extends BabioonEventViewObject
{
	/**
	 * Default view, list of items
	 * 
	 * @param string $tpl
	 */
    function display($tpl = null)
	{
		// Submit an event		
	    if($this->getLayout() == 'form')
	    {
	        $this->displayForm();
	        return true;
	    }
	    
	    if($this->getLayout() == 'presubmit')
	    {
	        $this->displayPresubmit();
	        return true;
	    }
	    
	    if($this->getLayout() == 'submit')
	    {
	        $this->displaySubmit();
	        return true;
	    }

	    // export event data
	    if($this->getLayout() == 'eform')
	    {
	        $this->displayEForm();
	        return true;
	    }
	    
	    if($this->getLayout() == 'export')
	    {
	        $this->displayExport();
	        return true;
	    }

	    // searchform
	    // export event data
	    if($this->getLayout() == 'sform')
	    {
	        $this->displaySForm();
	        return true;
	    }
	    
	    if($this->getLayout() == 'result')
	    {
	        $this->displayResult();
	        return true;
	    }

        // default is to show the event
        $this->assignRef('element', $this->get('Item')) ;	    
	    parent::display($tpl);
	}
    
    /**
     * Show the adding a new event form
     * @return void
     */
	function displayForm()
	{
	    $this->addTemplatePath(dirname(__FILE__).'/../legacy');
		$model = $this->getModel();
		$this->assignRef('form', $model->getForm('add')) ;
		$this->assign('showerror',false);
		parent::display();
	}

	/**
	 * display a check setting site before commit the new event
	 * @return void
	 */
	function displayPresubmit()
	{
	    $this->addTemplatePath(dirname(__FILE__).'/../legacy');
		$model = $this->getModel();
		$form = $model->getForm('add');
		$result = $model->checkValuesEventForm($form);
		$this->assignRef('error',$result[1]);
		$this->assignRef('form',$result[0]);
		$task=JFactory::getApplication()->input->getCmd('task');
		$showerror = !empty($this->error) && $task != 'change';
		$this->assign('showerror',$showerror);
		
		if ($showerror OR $task == 'change')
		{
			$this->setLayout('form');
		}
		else
		{
			// MAKE GOOGLE MAGIC
			$geomsg='';
			if ($this->get('State')->params->get('getgeo',1) == 2)
			{
				$geomsg=$model->getGeoCoordinate();
			}	
			$this->assign('geomsg',$geomsg);
			$this->assignRef('categoryname',$model->getCategoryName());
			$hereweare = md5(date('r.-.Z'));
			$this->assign('hereweare',$hereweare);
			$model->setUserState( 'hereweare', $this->hereweare );
			$this->assign('showerror',false);
		}
		
		parent::display();
	}
	
	/**
	 * display a event a success or failure message
	 * @return [type]
	 */
	function displaySubmit()
	{
	    $this->addTemplatePath(dirname(__FILE__).'/../legacy');
		$model = $this->getModel();
		$this->assignRef('result',$model->saveFormData());
		parent::display();
	}

   /**
     * Show the export events form
     * @return void
     */
	function displayEForm()
	{
	    $this->addTemplatePath(dirname(__FILE__).'/../legacy');
		$model = $this->getModel();
		$this->assignRef('categorylist',$model->getCategoryList());
		$this->assignRef('form', $model->getForm('export')) ;
		$this->assign('showerror',false);
		parent::display();
	}

	/**
	 * show the export files for download
	 * @return void
	 */
	function displayExport()
	{
	    $this->addTemplatePath(dirname(__FILE__).'/../legacy');
		$model = $this->getModel();
		$form = $model->getForm('export');
		$result = $model->checkValuesExportForm($form);
		$this->assignRef('error',$result[1]);
		$this->assignRef('form',$result[0]);
		$showerror = !empty($this->error);
		$this->assign('showerror',$showerror);
		if ($showerror)
		{
			$this->assignRef('categorylist',$model->getCategoryList());
			$this->setLayout('eform');
		}
		else
		{
			$this->assignRef('files',$model->getExportFile());
		}	
		parent::display();
	}
	
}