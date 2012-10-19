<?php

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'event.cancel' || document.formvalidator.isValid(document.id('event-form'))) {
			Joomla.submitform(task, document.getElementById('event-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_babioonevent&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="event-form" class="form-validate">
	<div class="width-100 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_BABIOONEVENT_EVENT_NEW') : JText::sprintf('COM_BABIOONEVENT_EVENT_DETAILS', $this->item->id); ?></legend>
			<ul class="adminformlist">

				<?php $field='id';?>	
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>
			
				<?php $field='published';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='name';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='catid';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='organiser';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='sdate';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='stimehh';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='stimemm';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='edate';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='etimehh';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='etimemm';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='contact';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='email';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='showemail';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='tel';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='website';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='address';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='ainfo';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='street';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='pcode';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='city';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='state';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='country';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>
				
				<?php $field='teaser';?>
				<li><?php echo $this->form->getLabel($field); ?>
				<div class="clr"> </div>
				<?php echo $this->form->getInput($field); ?></li>
				
				<?php $field='text';?>
				<li><?php echo $this->form->getLabel($field); ?>
				<div class="clr"> </div>
				<?php echo $this->form->getInput($field); ?></li>
				
				<?php $field='isfreeofcharge';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

				<?php $field='charge';?>			
				<li><?php echo $this->form->getLabel($field); ?>
				<?php echo $this->form->getInput($field); ?></li>

			</ul>
			<div class="clr"> </div>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
