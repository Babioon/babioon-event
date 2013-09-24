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

if (empty($displayData->component))
{
	$displayData->component = 'com_babioonevent';
}

$category = '';
$found    = false;
$option   = JHtml::_('category.categories', 'com_babioonevent');
$value    = $displayData->form->getValue($displayData->fieldname);

while ((list($key, $elm) = each($option)) && !$found )
{
	if ($elm->value == $value)
	{
		$category = $elm->text;
		$found    = true;
	}
}


?>
<strong><?php echo JText::_('COM_BABIOONEVENT_' . strtoupper($displayData->fieldname)); ?></strong>
<div class="well well-small">
	<?php echo $category; ?>
</div>
