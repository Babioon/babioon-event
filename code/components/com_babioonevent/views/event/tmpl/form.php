<?php
/**
 * babioon event
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_EVENT
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

$pageclass_sfx   = $this->params->get('pageclass_sfx','');
$subheaderlevel  = $this->headerlevel+1;
$subheaderlevel2 = $this->headerlevel+2; 
$subheaderlevel3 = $this->headerlevel+3; 

$this->params = $this->params;
?>

<div id="event<?php echo $pageclass_sfx;?>">

<?php if ($this->showerror) 
{
	$title=JText::_ ( 'COM_BABIOONEVENT_ERROR' );
	$this->document->setTitle ( JText::_ ( 'COM_BABIOONEVENT_ERROR_PT' ) );
	$this->preerrortext = JText::_ ( 'COM_BABIOONEVENT_ERRORSUBMITEVENT' );
	echo $this->loadTemplate('error',false);
}
else 
{
	echo "<h$this->headerlevel>".$this->title."</h$this->headerlevel>";
	echo JText::_('COM_BABIOONEVENT_HEADTEXTSUBMITEVENT');	
}

$action = JRoute::_ ( 'index.php' );
echo '<form action="' . $action . '#content" method="post" name="rdeventaddform" class="event_form">';
// standard fields
echo '<input type="hidden" name="option" value="com_babioonevent" />';
echo '<input type="hidden" name="view" value="event" />';
echo '<input type="hidden" name="task" value="" />';
echo '<input type="hidden" name="layout" value="presubmit" />';
echo '<fieldset><legend>'.JText::_ ( 'COM_BABIOONEVENT_ADDDATA' ).'</legend>';

echo JText::_ ( 'COM_BABIOONEVENT_ADDDATAINFO' );


$i=0;
// name is always in the form
$elm=$this->form[$i];
$this->assign('elm',$elm);
echo $this->loadTemplate($elm['type'],false);	

$i++;
if ($this->params->get('showorganiser',2) != 0)
{
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;	
}
echo '</fieldset>';
$confvar = $this->params->get('showdates',4);
if ($confvar != 0)
{
	echo '<fieldset>';
	echo '<legend>'.JText::_('COM_BABIOONEVENT_START').'</legend>';
	
	echo JText::_ ( 'COM_BABIOONEVENT_STARTINFO' );
	
	// startdate
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
	// starttime
	if ($confvar == 2 OR $confvar == 4 OR $confvar == 5 OR $confvar == 7 OR $confvar == 8 OR ($confvar >= 10 AND $confvar != 14) )
	{
		$elm=$this->form[$i];

		$elm['timeset'] = ($elm['value'] != '--' || $elm['value'] == '');
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
	}
	echo '</fieldset>';
	if ( $confvar >= 6 )
	{
		echo '<fieldset>';
		echo '<legend>'.JText::_('COM_BABIOONEVENT_END').'</legend>';
		
		echo JText::_ ( 'COM_BABIOONEVENT_ENDINFO' );
		
		$elm=$this->form[$i];
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
		if ($confvar == 8 OR $confvar == 12 OR $confvar == 13 OR $confvar >= 17 )
		{
			$elm=$this->form[$i];
			$this->assign('elm',$elm);
			echo $this->loadTemplate($elm['type'],false);	
			$i++;
		}
		echo '</fieldset>';	
	}
}

$cinfo = (int) $this->params->get('showcontact',1) + (int) $this->params->get('showphone',1) + (int) $this->params->get('showwebsite',1)+ (int) $this->params->get('showemail',1);
if ($cinfo != 0)
{
	echo '<fieldset>';
	echo '<legend>'.JText::_('COM_BABIOONEVENT_CONTACTPERSON').'</legend>';
	
	echo JText::_ ( 'COM_BABIOONEVENT_CONTACTPERSONINFO' );
	
	if ($this->params->get('showcontact',1) != 0)
	{
		$elm=$this->form[$i];
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
	}
	if ($this->params->get('showphone',1) != 0)
	{
		$elm=$this->form[$i];
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
	}
	if ($this->params->get('showwebsite',1) != 0)
	{
		$elm=$this->form[$i];
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
	}
	if ($this->params->get('showemail',1) != 0)
	{
		$elm=$this->form[$i];
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
		$elm=$this->form[$i];
		$this->assign('elm',$elm);
		echo $this->loadTemplate($elm['type'],false);	
		$i++;
	}
	echo '</fieldset>';	
}
$locationconfvar=$this->params->get('showlocation',1);
if ($locationconfvar > 2)
{
	echo '<fieldset>';
	echo '<legend>'.JText::_('COM_BABIOONEVENT_LOCATION').'</legend>';
	
	if ($locationconfvar == 5) 
	{
		echo JText::_('COM_BABIOONEVENT_LOCATIONINFOGOOGLE');
	}
	else 
	{
		echo JText::_('COM_BABIOONEVENT_LOCATIONINFO');	
	}
	
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
	echo '</fieldset>';	
}

echo '<fieldset>';
echo '<legend>' . JText::_ ( 'COM_BABIOONEVENT_EVENTDESCRIPTION' ) . '</legend>';

echo JText::_ ( 'COM_BABIOONEVENT_EVENTDESCRIPTIONINFO' );

if ($locationconfvar != 0 AND $locationconfvar < 3)
{
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
}

if ($this->params->get('showshortdesc',2) != 0)
{
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
}
if ($this->params->get('showlongdesc',2) != 0)
{
	$elm=$this->form[$i];
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
}
$list=array();
// is free of charge
$obj= new stdClass();
$obj->value = 0;
$obj->text = JText::_ ( 'NOFREEOFCHARGE' );
$list[]=$obj;
unset($obj);
$obj= new stdClass();
$obj->value = 1;
$obj->text = JText::_ ( 'YESFREEOFCHARGE' );
$list[]=$obj;
unset($obj);

$elm=$this->form[$i];
$elm['list'] = $list;
$elm['defaultvalue'] = 1;

$this->assign('elm',$elm);
echo $this->loadTemplate($elm['type'],false);	
$i++;

$elm=$this->form[$i];
$this->assign('elm',$elm);
echo $this->loadTemplate($elm['type'],false);	
$i++;

if ($this->params->get('showcategory',2) != 0)
{
	$elm=$this->form[$i];
	$elm['defaultvalue']=$this->params->get('defaultcategory',0);
	$this->assign('elm',$elm);
	echo $this->loadTemplate($elm['type'],false);	
	$i++;
}
echo '</fieldset>';	

echo '<div class="note">'.JText::_('COM_BABIOONEVENT_NOTESUBMITEVENT').'</div>';
echo '<div class="formelm"><input type="submit" value="'. JText::_('COM_BABIOONEVENT_SEND').'" class="button" /> </div>';

echo "\n".'</form>';


?>
</div> <!-- id=event -->
