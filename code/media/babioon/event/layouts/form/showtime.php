<?php
/**
 * babioon layouts
 * @package    BABIOON_LAYOUTS
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;
$hh = $displayData->form->getValue($displayData->fieldname . 'hh');
$mm = $displayData->form->getValue($displayData->fieldname . 'mm');
$value = $hh . ':' . $mm;

if ($value == ':')
{
	$value = JText::_('COM_BABIOONEVENT_NODATASET');
}
?>

<strong><?php echo JText::_('COM_BABIOONEVENT_' . strtoupper($displayData->fieldname)); ?></strong>
<div class="well well-small">
	<?php echo $value; ?>
</div>

