<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die ('Restricted access');

$pageclass_sfx = $this->params->get('pageclass_sfx', '');

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