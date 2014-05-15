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
$form 			= $this->form;
$params 		= JComponentHelper::getParams('com_babioonevent');
$keys 			= array_keys($form->getFieldset());
$showlocation   = $params->get('showlocation', 2);
$headerlevel    = $params->get('headerlevel', 1);
$Itemid 		= BabioonEventRouteHelper::getItemid('export');

$errors 		= $this->getModel()->getErrors();
$error 			= !empty($errors);

if ($form->getValue('sdate') == '0000-00-00')
{
	$form->setValue('sdate', '');
}

if ($form->getValue('edate') == '0000-00-00')
{
	$form->setValue('edate', '');
}

$title = JLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');
?>
<!-- ************************** START: babioonevent ************************** -->
<div class="babioonevent">

	<?php if ($error)
	{
		echo "<h$headerlevel>" . JText::_('COM_BABIOONEVENT_ERROR') . "</h$headerlevel>";

		$displayData->pretext = JText::_('COM_BABIOONEVENT_ERRORSUBMITEVENT');
		$displayData->errors = $errors;
		echo JLayoutHelper::render('form.error', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');
	}
	else
	{
		echo "<h$headerlevel>" . $title . "</h$headerlevel>";
		echo JText::_('COM_BABIOONEVENT_HEADTEXTEXPORTEVENT');
	}

	?>
	<form action="index.php?option=com_babioonevent&view=event&layout=export&Itemid=<?php echo $Itemid;?>" method="post" name="adminForm" class="form-horizontal">
		<fieldset>
			<legend><?php echo JText::_('COM_BABIOONEVENT_ADDDATA');?></legend>

			<?php $f = 'sdate'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'edate'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'catid'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php $displayData->removeRoot = true; ?>
			<?php if ($error) : ?>
				<?php $displayData->selectAll = false; ?>
				<?php $displayData->selected = $this->input->get('excatid');?>
			<?php else :?>
				<?php $displayData->selectAll = true; ?>
			<?php ?>
			<?php endif; ?>

			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo JLayoutHelper::render('form.categoriesselect', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

		</fieldset>

		<div class="note"><?php echo JText::_('COM_BABIOONEVENT_NOTEEXPORTEVENT'); ?></div>

		<div class="form-actions">
			<input type="submit" value="<?php echo JText::_('COM_BABIOONEVENT_EXPORT');?>" class="btn btn-primary" />
		</div>

		<input type="hidden" name="option" value="com_babioonevent" />
		<input type="hidden" name="view" value="event" />
		<input type="hidden" name="task" value="eresult" />
		<input type="hidden" name="layout" value="export" />
		<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	</form>
</div>
<!-- *************************** END: babioonevent *************************** -->