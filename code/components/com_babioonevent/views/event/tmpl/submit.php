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
if ($this->result)
{
	$msg = JText::_('COM_BABIOONEVENT_THANKYOUMSG');
}
else
{
	$msg = JText::_('COM_BABIOONEVENT_SORRYMSG');
}
?>

<div id="event<?php echo $pageclass_sfx;?>">
	<h<?php echo $this->headerlevel;?>><?php echo $this->title;?></h<?php echo $this->headerlevel;?>>
	<?php echo $msg;?>
</div> <!-- id=event -->