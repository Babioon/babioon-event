<?php
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$fields=array(	'id','published','name','catid','organiser','sdate','stimehh','stimemm',
				'edate','etimehh','etimemm','contact','email','showemail','website','address','ainfo',
				'pcode','city','state','country','teaser','text','isfreeofcharge','charge');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == '<?php echo $this->objname; ?>.cancel' || document.formvalidator.isValid(document.id('<?php echo $this->objname; ?>-form'))) {
			Joomla.submitform(task, document.getElementById('<?php echo $this->objname; ?>-form'));
		}
	}
</script>

<div class="span10">

<form action="<?php echo JRoute::_('index.php?option=com_babioonevent&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="<?php echo $this->objname; ?>-form" class="form-validate">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_BABIOONEVENT_EVENT_NEW') : JText::sprintf('COM_BABIOONEVENT_EVENT_DETAILS', $this->item->id); ?></legend>
			<div class=" form-horizontal">
    			<?php foreach ($fields AS $field) :?>

    				<div class="control-group">
    					<div class="control-label">
    						<?php echo $this->form->getLabel($field); ?>
    					</div>
    					<div class="controls">
    						<?php echo $this->form->getInput($field); ?></li>
    					</div>
    				</div>
    			<?php endforeach;?>
    		</div>
		</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

</div>
