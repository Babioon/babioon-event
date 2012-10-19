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
?>

<div id="event<?php echo $pageclass_sfx;?>">

<?php
if ($this->showerror)
{
	$title=JText::_ ( 'COM_BABIOONEVENT_ERROREXPORTTITLE' );
	$this->document->setTitle ( JText::_ ( 'COM_BABIOONEVENT_ERROREXPORTTITLE_PT' ) );
	$this->preerrortext = JText::_ ( 'COM_BABIOONEVENT_ERROREXPORT' );
	echo $this->loadTemplate('error',false);
}
else 
{
	echo "<h$this->headerlevel>".$this->title."</h$this->headerlevel>";
	echo JText::_('COM_BABIOONEVENT_HEADTEXTEXPORTEVENT');	
}

$action = JRoute::_ ( 'index.php' );
echo '<form action="' . $action . '#content" method="post" name="EventForm" class="event_form">';
// standard fields
echo '<input type="hidden" name="option" value="com_babioonevent" />';
echo '<input type="hidden" name="view" value="event" />';
echo '<input type="hidden" name="task" value="" />';
echo '<input type="hidden" name="layout" value="export" />';

echo '<fieldset><legend>'.JText::_ ( 'COM_BABIOONEVENT_EXPORTDATES' ).'</legend>';

$i=0;
// start is always in the form
$elm=$this->form[$i];
$this->assign('elm',$elm);
echo $this->loadTemplate($elm['type'],false);	
$i++;

// end is always in the form
$elm=$this->form[$i];
$this->assign('elm',$elm);
echo $this->loadTemplate($elm['type'],false);	
$i++;
echo '</fieldset>';

echo '<fieldset><legend>'.JText::_ ( 'COM_BABIOONEVENT_CATEGORIES' ).'</legend>';
// catid
/*
$elm=$this->form[$i];
$elm['list'] = $this->categorylist;
$this->assign('elm',$elm);
echo $this->loadTemplate($elm['type'],false);	
 */

echo $this->categorylist;


echo '</fieldset>';

echo '<div class="note">'.JText::_('COM_BABIOONEVENT_NOTEEXPORTEVENT').'</div>';
echo '<div class="formelm"><input type="submit" value="'. JText::_('COM_BABIOONEVENT_EXPORT').'" class="button" /> </div>';;
echo '</form>';
?>
</div> <!-- id=event -->
