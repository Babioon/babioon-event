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
?>
<div class="alert alert-error">
	<?php if (property_exists($displayData, 'pretext')) : ?>
		<strong><?php echo $displayData->pretext; ?></strong>
	<?php endif; ?>
	<?php if (!empty($displayData->errors)) : ?>
		<ul>
		<?php foreach ($displayData->errors as $error) : ?>
		<li>
			<?php if ($error instanceof Exception) : ?>
			<?php echo $error->getMessage(); ?>
		<?php else : ?>
			<?php echo $error; ?>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
