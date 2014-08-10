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

JHtml::_('behavior.framework');

$displayData 	= new stdClass;
$params 		= JComponentHelper::getParams('com_babioonevent');
$headerlevel    = $params->get('headerlevel', 1);
$Itemid 		= BabioonEventRouteHelper::getItemid('event');

$csvfile 		= $this->files[0];
$txtfile 		= $this->files[1];

$title = JText::_('COM_BABIOONEVENT_EXPORTRESULT');
?>
<!-- ************************** START: babioonevent ************************** -->
<div id="babioonevent">

	<?php echo "<h$headerlevel>" . $title . "</h$headerlevel>"; ?>

	<?php if (trim($csvfile) == '' && trim($txtfile) == '') : ?>
		<?php echo JText::_('COM_BABIOONEVENT_EXPORTFAIL'); ?>
	<?php else : ?>
		<?php echo JText::_('COM_BABIOONEVENT_EXPORTINTRO'); ?>
	<?php endif; ?>

    <?php if (trim($csvfile) != '') : ?>
        <?php echo '<p><a class="readon" href="'.$csvfile.'">'.JText::_('COM_BABIOONEVENT_EXPORTDLLINK').'</a></p>'; ?>
    <?php endif; ?>

    <?php if (trim($txtfile) != '') : ?>
       	<?php echo '<p><a class="readon" href="'.$txtfile.'">'.JText::_('COM_BABIOONEVENT_EXPORTDLLINK1').'</a></p>'; ?>
    <?php endif; ?>

</div>
<!-- *************************** END: babioonevent *************************** -->