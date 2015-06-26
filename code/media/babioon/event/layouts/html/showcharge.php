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
$value = $displayData->form->getValue($displayData->fieldname);
?>

<strong><?php echo JText::_('COM_BABIOONEVENT_' . strtoupper($displayData->fieldname)); ?></strong>
<div class="well well-small">
	<?php echo $value; ?>
</div>