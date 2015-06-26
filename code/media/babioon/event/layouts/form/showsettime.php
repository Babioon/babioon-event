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
$hh = str_pad($displayData->form->getValue($displayData->fieldname . 'hh'), 2, '0', STR_PAD_LEFT);
$mm = str_pad($displayData->form->getValue($displayData->fieldname . 'mm'), 2, '0', STR_PAD_LEFT);
$value = $hh . ':' . $mm;
?>
<?php if ($value != ':') : ?>
	<strong><?php echo JText::_('COM_BABIOONEVENT_' . strtoupper($displayData->fieldname)); ?></strong>
	<div class="well well-small">
		<?php echo $value; ?>
	</div>
<?php endif; ?>
