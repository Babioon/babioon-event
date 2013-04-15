<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die ('Restricted access');

$pageclass_sfx   = $this->params->get('pageclass_sfx','');
$subheaderlevel  = $this->headerlevel+1;
$subheaderlevel2 = $this->headerlevel+2;
$subheaderlevel3 = $this->headerlevel+3;
?>

<div id="event<?php echo $pageclass_sfx;?>">

<?php
echo "<h$this->headerlevel>".JText::_('COM_BABIOONEVENT_CHECKDATA')."</h$this->headerlevel>";
$this->setPageTitle(JText::_('COM_BABIOONEVENT_CHECKDATA_PT'));

echo JText::_('COM_BABIOONEVENT_HEADTEXTSUBMITPAGE');

echo '<h'.$subheaderlevel.'>'.JText::_('COM_BABIOONEVENT_EVENTDATA').'</h'.$subheaderlevel.'>';

$i=0;
// name
$elm = $this->form[$i];
echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
echo '<p class="box">',$elm['value'],'</p>';
$i++;

// organiser
if ($this->params->get('showorganiser',2) != 0)
{
	$elm = $this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
}
$confvar = $this->params->get('showdates',4);
if ($confvar != 0)
{
	echo '<h'.$subheaderlevel.'>'.JText::_('COM_BABIOONEVENT_START').'</h'.$subheaderlevel.'>';

	// startdate
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? date('d.m.Y',strtotime($elm['value'])) : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
	// starttime
	if ($confvar == 2 OR $confvar == 4 OR $confvar == 5 OR $confvar == 7 OR $confvar == 8 OR ($confvar >= 10 AND $confvar != 14) )
	{
		$elm=$this->form[$i];
		echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
		echo '<p class="box">';
		echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
		echo '</p>';
		$i++;
	}
	if ( $confvar >= 6 )
	{
		echo '<h'.$subheaderlevel.'>'.JText::_('COM_BABIOONEVENT_END').'</h'.$subheaderlevel.'>';
		$elm=$this->form[$i];
		echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
		echo '<p class="box">';
		echo trim($elm['value']) != '' ? date('d.m.Y',strtotime($elm['value'])) : JText::_('COM_BABIOONEVENT_NODATASET');
		echo '</p>';
		$i++;
		if ($confvar == 8 OR $confvar == 12 OR $confvar == 13 OR $confvar >= 17 )
		{
			$elm=$this->form[$i];
			echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
			echo '<p class="box">';
			echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
			echo '</p>';
			$i++;
		}
	}
}

$cinfo = (int) $this->params->get('showcontact',1) + (int) $this->params->get('showphone',1) + (int) $this->params->get('showwebsite',1)+ (int) $this->params->get('showemail',1);
if ($cinfo != 0)
{

	echo '<h'.$subheaderlevel.'>'.JText::_('COM_BABIOONEVENT_CONTACTPERSON').'</h'.$subheaderlevel.'>';

	if ($this->params->get('showcontact',1) != 0)
	{
		$elm=$this->form[$i];
		echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
		echo '<p class="box">';
		echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
		echo '</p>';
		$i++;
	}
	if ($this->params->get('showphone',1) != 0)
	{
		$elm=$this->form[$i];
		echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
		echo '<p class="box">';
		echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
		echo '</p>';
		$i++;
	}
	if ($this->params->get('showwebsite',1) != 0)
	{
		$elm=$this->form[$i];
		echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
		echo '<p class="box">';
		echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
		echo '</p>';
		$i++;
	}
	if ($this->params->get('showemail',1) != 0)
	{
		$elm=$this->form[$i];
		echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
		echo '<p class="box">';
		$emailvalue = trim($elm['value']) ;
		echo  $emailvalue != '' ? $emailvalue : JText::_('COM_BABIOONEVENT_NODATASET');
		echo '</p>';
		$i++;
		$elm=$this->form[$i];
		$i++;
		if ($emailvalue != '')
		{
			if ($elm['value'] == 1)
			{
				echo JText::_('COM_BABIOONEVENT_WESHOWTHEEMAIL');
			}
			else
			{
				echo JText::_('COM_BABIOONEVENT_WEDONTSHOWTHEEMAIL');
			}
		}

	}
}

$locationconfvar=$this->params->get('showlocation',1);
if ($locationconfvar > 2)
{
	echo '<h'.$subheaderlevel.'>'.JText::_('COM_BABIOONEVENT_LOCATION').'</h'.$subheaderlevel.'>';
	if ($locationconfvar == 5)
	{
		// Geocoordintes notice
		if ($this->geomsg != '')
		{
			echo JText::_($this->geomsg);
		}
	}
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? $elm['value'] : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
}

echo '<h'.$subheaderlevel.'>'.JText::_('COM_BABIOONEVENT_EVENTDESCRIPTION').'</h'.$subheaderlevel.'>';

if ($locationconfvar != 0 AND $locationconfvar < 3)
{
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? nl2br($elm['value']) : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
}

if ($this->params->get('showshortdesc',2) != 0)
{
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? nl2br($elm['value']) : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
}
if ($this->params->get('showlongdesc',2) != 0)
{
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">';
	echo trim($elm['value']) != '' ? nl2br($elm['value']) : JText::_('COM_BABIOONEVENT_NODATASET');
	echo '</p>';
	$i++;
}


$elm=$this->form[$i];
echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
echo '<p class="box">';
echo $elm['value'] == 0 ? JText::_ ( 'NOFREEOFCHARGE' ) :  JText::_ ( 'YESFREEOFCHARGE' );
echo '</p>';
$i++;

$elm=$this->form[$i];
echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
echo '<p class="box">';
echo trim($elm['value']) != '' ? nl2br($elm['value']) : JText::_('COM_BABIOONEVENT_NODATASET');
echo '</p>';
$i++;

if ($this->params->get('showcategory',2) != 0)
{
	$elm=$this->form[$i];
	echo '<h'.$subheaderlevel2.'>',JText::_($elm['labletag']),'</h'.$subheaderlevel2.'>';
	echo '<p class="box">',$this->categoryname,'</p>';
	$i++;
}

?>

<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="EventForm">
	<input type="submit" value="<?php echo JText::_('COM_BABIOONEVENT_SEND'); ?>" class="button" />
	<input type="hidden" name="option" value="com_babioonevent" />
	<input type="hidden" name="view" value="event" />
	<input type="hidden" name="layout" value="submit" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="hereweare" value="<?php echo $this->hereweare; ?>" />
</form>

<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="EventFormChange">
	<input type="submit" value="<?php echo JText::_('COM_BABIOONEVENT_CHANGE'); ?>" class="button" />
	<input type="hidden" name="option" value="com_babioonevent" />
	<input type="hidden" name="view" value="event" />
	<input type="hidden" name="layout" value="presubmit" />
	<input type="hidden" name="task" value="change" />
	<input type="hidden" name="hereweare" value="<?php echo $this->hereweare; ?>" />
</form>

</div> <!-- id=event -->