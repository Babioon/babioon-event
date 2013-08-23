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
$displayData = new stdClass;
$params 	 = JComponentHelper::getParams('com_babioonevent');
$headerlevel = $params->get('headerlevel', 1);
$title       = FOFLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');
?>
<!-- **************** start event **************** -->
<div class="babioonevent">

	<h<?php echo $headerlevel;?>>
		<?php echo $title;?>
	</h<?php echo $headerlevel;?>>

	<?php echo JText::_('COM_BABIOONEVENT_THANKYOUMSG');?>
</div>
<!-- **************** end event **************** -->