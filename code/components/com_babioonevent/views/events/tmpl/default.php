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
$slevel			= $headerlevel+1;
$Itemid 		= BabioonEventRouteHelper::getItemid('events');

$title = FOFLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');

$month	= '';
$close  = '';

?>
<!-- ************************** START: babioonevent ************************** -->
<div class="babioonevent">

	<h<?php echo $headerlevel;?>>
		<?php echo $title;?>
	</h<?php echo $headerlevel;?>>

	<div id="liste">

		<?php if (!empty($this->items)) : ?>
			<?php foreach ($this->items AS $elm) : ?>
				<?php $emon = date('m', strtotime($elm->sdate)); ?>
				<?php if ($emon != $month) : ?>
					<?php echo $close; ?>
					<?php $month = $emon; ?>
					<h<?php echo $slevel;?>>
						<?php echo JText::_(date('F', strtotime($elm->sdate))) . ' ' . date('Y', strtotime($elm->sdate)); ?>
					</h<?php echo $slevel;?>>
					<ul class="liste">
						<?php $close = '</ul>';?>
				<?php endif;?>
						<li>
							<?php if ($elm->edate != '0000-00-00' && $elm->sdate != '0000-00-00') :?>
								<?php $sd = date('d.m.Y', strtotime($elm->sdate));?>
								<?php $ed = date('d.m.Y', strtotime($elm->edate));?>
								<?php echo $sd == $ed ? $sd : $sd . ' - ' . $ed; ?>:&nbsp;
							<?php else : ?>
								<?php if ($elm->sdate != '0000-00-00') : ?>
									<?php echo date('d.m.Y', strtotime($elm->sdate));?>:&nbsp;
								<?php endif;?>
							<?php endif;?>
							<a href="<?php echo $elm->link; ?>">
								<?php echo $elm->name;?>
							</a>
						</li>
			<?php endforeach; ?>
			<?php echo $close;?><!-- CLOSE ul -->
		<?php else : ?>
			<?php echo JText::_('COM_BABIOONEVENT_DEFAULTLISTNORESULT'); ?>
		<?php endif;?>
	</div>

	<div class="pagination">
    	<?php echo $this->pagination->getPagesLinks(); ?>
    </div>

</div>
<!-- *************************** END: babioonevent *************************** -->