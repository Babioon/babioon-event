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
$slevel=$this->headerlevel+1;
$s2level=$this->headerlevel+2;
$this->gmaphlevel=$s2level;

$data=$this->element;

$link2start='index.php?option=com_babioonevent&view=events&Itemid='.BabioonEventRouteHelper::getItemid();
?>

<div id="event<?php echo $pageclass_sfx;?>">
	<h<?php echo $this->headerlevel;?>><?php echo $this->title;?></h<?php echo $this->headerlevel;?>>




<?php
echo "<h$this->headerlevel>".JText::_('COM_BABIOONEVENT_EVENTDETAIL')."</h$this->headerlevel>";

$data=$this->element;

if ($data->name != "")
{
	echo "<h$slevel>".$data->name."</h$slevel>";

	echo '<dl class="eventdetail">';
	if ($data->params->get('showorganiser',2) != 0)
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_ORGANISER').'</dt>';
		echo '<dd>'.$data->organiser.'</dd>';
	}
	$confvar = $data->params->get('showdates',4);
	if ($confvar != 0)
	{
		if ($data->sdate != '0000-00-00')
		{
			echo '<dt>'.JText::_('COM_BABIOONEVENT_START').'</dt>';
			$z_time = strtotime($data->sdate);
			echo '<dd>'.date('d.m.Y',$z_time).'</dd>';
			if ($data->stimeset == 1)
			{
				echo '<dt>'.JText::_('COM_BABIOONEVENT_STIME').'</dt>';
				echo '<dd>'.substr($data->stime,0,5).'</dd>';
			}
			if ($data->edate != '0000-00-00')
			{
				echo '<dt>'.JText::_('COM_BABIOONEVENT_END').'</dt>';
				echo '<dd>'.date('d.m.Y',strtotime($data->edate)).'</dd>';
				if ($data->etimeset == 1)
				{
					echo '<dt>'.JText::_('COM_BABIOONEVENT_ETIME').'</dt>';
					echo '<dd>'.substr($data->etime,0,5).'</dd>';
				}
			}
		}
	}
	if ($data->params->get('showcontact',1) != 0 && $data->contact != '')
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_CONTACT').'</dt>';
		echo '<dd>'.$data->contact.'</dd>';
	}
	if ($data->params->get('showphone',1) != 0 && $data->tel != '')
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_TEL').'</dt>';
		echo '<dd>'.$data->tel.'</dd>';
	}
	if ($data->params->get('showwebsite',1) != 0 && $data->website != '')
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_WEBSITE').'</dt>';
		echo '<dd>'.$data->website.'</dd>';
	}
	if ($data->params->get('showemail',1) != 0 && $data->showemail == 1 && $data->email != '')
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_EMAIL').'</dt>';
		echo '<dd>'.$data->email.'</dd>';
	}

	if($data->isfreeofcharge == 1 )
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_CHARGE').'</dt>';
		echo '<dd>'.JText::_('COM_BABIOONEVENT_ITISFREEOFCHARGE').'</dd>';
	}
	else
	{
		echo '<dt>'.JText::_('COM_BABIOONEVENT_CHARGE').'</dt>';
		echo '<dd>'.$data->charge.'</dd>';
	}

	$confvar=$data->params->get('showlocation',1);
	if ($confvar != 0)
	{
		if ($data->street != '' || $data->pcode != '' || $data->city != '' )
		{
			echo '<dt>'.JText::_('COM_BABIOONEVENT_ADDRESS').'</dt>';
			echo '<dd><address>';
			echo trim($data->ainfo) 	!= '' ? $data->ainfo  . '<br />' 	: '' ;
			echo trim($data->street) 	!= '' ? $data->street . '<br />' 	: '' ;
			echo trim($data->pcode) 	!= '' ? $data->pcode  . ' ' 	 	: '' ;
			echo trim($data->city) 		!= '' ? $data->city   . '' 			: '' ;
			echo '</address></dd>';
		}
		else
		{
			if ($data->address != '')
			{
				echo '<dt>'.JText::_('COM_BABIOONEVENT_ADDRESS').'</dt>';
				echo '<dd><address>';
				echo $data->address;
				echo '</address></dd>';
			}
		}
	}
	echo '</dl>';
	if (trim ($data->teaser .$data->text) != '')
	{
		echo "<h$s2level>".JText::_('COM_BABIOONEVENT_DESC')."</h$s2level>";
		echo '<div class="eventdesc">';
		echo $data->teaser .' '.$data->text;
		echo '</div>';
	}

	if ($data->params->get('showgmap',1) != 0)
	{
		if ($data->geo_b != '' && $data->geo_l != '')
		{
			$maps=BabioonGooglemaps::getInstance();
			$randid=rand(1000,9999);
			$doc = JFactory::getDocument();
			$name=str_replace(array('"',"'"), '', $data->name);

			$script='
				  	function initialize'.$randid.'()
				  	{
						var myLatlng = new google.maps.LatLng('.$data->geo_b.', '.$data->geo_l.');
						var myOptions = {
  										zoom: '.$data->params->get('gmapdefzoom',14).',
  										center: myLatlng,
  										mapTypeId: google.maps.MapTypeId.ROADMAP
										};
				  		var mapobj'.$randid.' = new google.maps.Map($("map'.$randid.'"), myOptions);

						var marker = new google.maps.Marker({
						      position: myLatlng,
						      title:"'.$name.'"
						  });

						  // To add the marker to the map, call setMap();
						  marker.setMap(mapobj'.$randid.');
				  	}
  					window.addEvent("domready",initialize'.$randid.');
				';
    		$doc->addScriptDeclaration($script);

		    echo "<h$s2level>".JText::_('COM_BABIOONEVENT_GMAPTITLE')."</h$s2level>";
		    echo '<div id="map'.$randid.'" style="width: 100%; height: 300px"></div>';
		}
	}
}
else
{
	echo JText::_('COM_BABIOONEVENT_NO_DATA_AVAILABLE');
}

?>
<div class="backnavi">
	<ul>
	<li><a href="<?php echo $link2start?>"><?php echo JText::_('COM_BABIOONEVENT_LINKSTART'); ?></a></li>
	</ul>
</div>
</div> <!-- id=event -->

