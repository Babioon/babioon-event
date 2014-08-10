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

$option = JHtml::_('category.categories', $displayData->component);

if (property_exists($displayData, 'removeRoot') && $displayData->removeRoot)
{
	// Eliminate "add to root"
	array_pop($option);
}

$selected = array();

if (property_exists($displayData, 'selectAll') && $displayData->selectAll)
{
	// All categories should be selected by default

	foreach ($option as $key => $value)
	{
		$selected[] = $value->value;
	}
}
else
{
	if (property_exists($displayData, 'selected'))
	{
		if (is_array($displayData->selected))
		{
			$selected = $displayData->selected;
		}
		else
		{
			$selected = (string) $displayData->selected;
		}
	}
}

?>
<div class="control-group">
	<?php echo $displayData->label; ?>
	<div class="controls">
		<?php echo JHtml::_('select.genericlist', $option, 'excatid[]', ' multiple="multiple" size="10"', 'value', 'text', $selected); ?>
	</div>
</div>
