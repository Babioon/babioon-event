<?php
/**
 * babioon koorga
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_KOORGA
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');

/**
 * BabioonKoorga Component Person Model
 */
class BabioonKoorgaModelService extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'com_babioonkoorga.service';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->get('id','uint');
		$this->setState('service.id', $pk);
		
		// Load the letter
		$value = $app->input->get('letter'); 
        $this->setState('letter', $value);
        
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
	}

	/**
	 * Method to get item data.
	 *
	 * @param	integer	The id of the item.
	 *
	 * @return	mixed	Menu item data object on success, false on failure.
	 */
	public function &getItem($pk = null)
	{
		// Initialise variables.
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('service.id');

		if ($this->_item === null) {
			$this->_item = array();
		}

		if (!isset($this->_item[$pk])) {

			try {
				$db = $this->getDbo();
				$query = $db->getQuery(true);
            	$query->select(
            			'a.id, a.name, ' .
            			'a.foritem, ' .
            			'a.desc, ' .
            			'a.checked_out, a.checked_out_time, ' .
            			'a.params, a.control, a.state '
            	);
            	$query->from('#__babioonkoorga_services AS a');
            	
            	// filter 
                $query->where('a.state = 1');
                $query->where('a.id = ' . (int) $pk);
				$db->setQuery($query);
				$data = $db->loadObject();
				if ($error = $db->getErrorMsg()) {
					throw new Exception($error);
				}

				if (empty($data)) {
					return JError::raiseError(404, JText::_('COM_BABIOONKOORGA_SERVICE_ERROR_NOT_FOUND'));
				}

				// Convert parameter fields to objects.
				$registry = new JRegistry;
				$registry->loadString($data->params);

				$data->params = clone $this->getState('params');
				$data->params->merge($registry);

        		$tp = strpos($data->desc, '<hr id="system-readmore" />');
        		if ($tp === false)	{
        			$data->intro = $data->desc;
        			$data->fulltext = '';
        		} else 	{
        			$data->intro = substr($data->desc, 0, $tp);
        			$data->fulltext = substr($data->desc, $tp+27);
        		}
        		
        		require_once dirname(__FILE__).'/../helpers/objectrelations.php';
        		/*
        		 * Get the related documents for a service
        		 */
        		// service M:N document
	            $r = BabioonKoorgaObjectRelations::getRelatedObjectsByReleatedObjType('service',$pk,'document',0,'i.name'); 
        		if (!empty($r))
        		{
        			$uploaddir = $data->params->get('documentuploaddir','images');
        			foreach($r as &$elm)
        			{
        			    $elm->islink =1;
        			    if ($elm->extern != 1)
        			    {
        					$lastslash=strrpos($elm->filename,DS);
        					$file=substr($elm->filename,$lastslash);
        					$elm->link = $uploaddir.'/'.$file;
        			    }
        			}
        		}
        		$data->docs = $r;
        		$data->person = array();
        		// service M:N position
	            $query->clear();    
        	    $query->select('i.*')
        	        ->from('#__babioonkoorga_obj2objrel AS r')
        	        ->from('#__babioonkoorga_positions AS i')
        	        ->where('r.relobj_id =' . (int) $pk)
        	        ->where('r.obj_id = i.id')
        	        ->where('r.reltype = 0')
        	        ->where('r.obj_type = '. BabioonKoorgaObjectRelations::mapObjtypeToCode('position'))
        	        ->where('r.relobj_type ='. BabioonKoorgaObjectRelations::mapObjtypeToCode('service'))
        	        ->orderby('i.ordering');
        		$db->setQuery($query);
                //echo nl2br(str_replace('#__','j25_',$query));    					    
    		    $pos =$db->loadObjectList();
				if ($error = $db->getErrorMsg()) {
					throw new Exception($error);
				}
    		    
        		if(!empty($pos))
        		{ 
        		    $person = array();
            		foreach($pos AS $row)
            		{    
            		    // position -> obj2obj -> person (N:1)
            		    $per=BabioonKoorgaObjectRelations::getRelatedObjectsByReleatedObjType('position',$row->id,'person');
            		    if(!empty($per))
            		    {
            		        // position -> communication, position -> location
            		        $personobj=$per[0];
            		        $personobj->position=$row;
            		        $personobj->cpos=BabioonKoorgaObjectRelations::getRelatedObjectsByReleatedObjType('position',$row->id,'communication',0,'i.type DESC');
            		        $personobj->lpos=BabioonKoorgaObjectRelations::getRelatedObjectsByReleatedObjType('position',$row->id,'location',0,'i.lft');
            		        $personobj->cper=BabioonKoorgaObjectRelations::getRelatedObjectsByReleatedObjType('person',$personobj->id,'communication',0,'i.type DESC');
            		        $person[]=clone($personobj);    
            		    }
            		}
                    $data->person=$person;
        		}           		
        		
        		
				$this->_item[$pk] = $data;
			}
			catch (JException $e)
			{
				if ($e->getCode() == 404) {
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				}
				else {
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}
		return $this->_item[$pk];
	}
	
	/**
	 * Get the related position objects for a service
	 *
	 * @return object
	 */
	public function getPositionData() 
	{
		if ($this->_item === null) {
			$this->getItem();
		}
		$id = (int) $this->getState('service.id');
		$item = $this->_item[$id];
		
	    $db = $this->getDbo();
		$query = $db->getQuery(true);
		
		// service M:N position N:1 person
        $query->select('p.*, s.obj_id ')
                ->from('#__babioonkoorga_obj2objrel as s')
                ->from('#__babioonkoorga_obj2objrel as r')
                ->from('#__babioonkoorga_persons as p')
                ->where('s.relobj_id = ' . $id)
                ->where('s.relobj_type = 230')
                ->where('s.obj_id = r.obj_id')
                ->where('s.obj_type = r.obj_type')
                ->where('r.relobj_id = p.id')
                ->where('r.relobj_type = 40')
                ->order('s.ordering, p.lastname');
        $db->setQuery($query);        
		$r1 = $db->loadObjectList ();
		if ($error = $db->getErrorMsg()) {
			throw new Exception($error);
		}
		
		$rc = count ( $r1 );
		for($i = 0; $i < $rc; $i ++) {
			$elm = $r1 [$i];
			// communication position
			$id = $elm->obj_id;
			$query->clear();
            $query->select('c.* ')
                    ->from('#__babioonkoorga_obj2objrel as r')
                    ->from('#__babioonkoorga_communications as c')
                    ->where('r.obj_id = ' . $id)
                    ->where('r.obj_type = 220')
                    ->where('r.relobj_type = 50')
                    ->where('r.relobj_id = c.id')
                    ->order('c.type DESC');
            $db->setQuery($query);        
    		$cpos = $db->loadObjectList ();
    		if ($error = $db->getErrorMsg()) {
    			throw new Exception($error);
    		}
    		
			// location
			$query->clear();
            $query->select('c.* ')
                    ->from('#__babioonkoorga_obj2objrel as r')
                    ->from('#__babioonkoorga_locations as c')
                    ->where('r.obj_id = ' . $id)
                    ->where('r.obj_type = 220')
                    ->where('r.relobj_type = 15')
                    ->where('r.relobj_id = c.id')
                    ->order('c.lft');
            $db->setQuery($query);        
    		$lpos = $db->loadObjectList ();
    		if ($error = $db->getErrorMsg()) {
    			throw new Exception($error);
    		}
    		
			// communication person
			$query->clear();
            $query->select('c.* ')
                    ->from('#__babioonkoorga_obj2objrel as r')
                    ->from('#__babioonkoorga_communications as c')
                    ->where('r.obj_id = ' . $id)
                    ->where('r.obj_type = 40')
                    ->where('r.relobj_type = 50')
                    ->where('r.relobj_id = c.id')
                    ->order('c.type');
            $db->setQuery($query);        
    		$cper = $db->loadObjectList ();
    		if ($error = $db->getErrorMsg()) {
    			throw new Exception($error);
    		}
    		
			$elm->cpos = $cpos;
			$elm->cper = $cper;
			$elm->lpos = $lpos;
			
			$result [] = $elm;
		
		}
		return $result;
	}
	/**
	 * results the set letter
	 */
	public function getLetter()
	{
	    return $this->getState('letter');
	}
	
}
