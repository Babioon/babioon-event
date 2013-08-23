<?php
// No direct access
defined('_JEXEC') or die;
$sidebar = JHtmlSidebar::render();
?>
<div id="babioonevent">
<?php if (!empty( $sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $sidebar; ?>
	</div>
	<div id="j-main-container" class="span10 well">
<?php else : ?>
	<div id="j-main-container well">
<?php endif;?>

		<?php echo JText::_('COM_BABIOONEVENT_COMP');?>
		<?php echo JText::_('COM_BABIOONEVENT_COMP_DESC');?>

		<div class="cpanel" style="padding:20px">

			<?php echo JText::_('COM_BABIOONEVENT_COMP_SUPPORT');?>
			<?php echo JText::_('COM_BABIOONEVENT_COMP_DOCS');?>
			<?php echo JText::_('COM_BABIOONEVENT_COMP_FORUM');?>

			<?php if (JFactory::getUser()->authorise('core.admin', 'com_babioonevent')) : ?>
				<?php echo LiveUpdate::getIcon(); ?>
			<?php endif;?>

		</div>
		<div class="clearfix"> </div>

		<p>
			<?php echo JText::_('COM_BABIOONEVENT_COPYRIGHT') . ' | ' . JText::_('COM_BABIOONEVENT_LICENSE'); ?>
		</p>
	</div>
</div>