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
$Itemid 		= BabioonEventRouteHelper::getItemid('search');

$errors 		= $this->getModel()->getErrors();

if ($form->getValue('sdate') == '0000-00-00')
{
	$form->setValue('sdate', '');
}

if ($form->getValue('edate') == '0000-00-00')
{
	$form->setValue('edate', '');
}

$title = FOFLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');
?>
<!-- ************************** START: babioonevent ************************** -->
<div class="babioonevent">

	<h<?php echo $headerlevel;?>>
		<?php echo $title;?>
	</h<?php echo $headerlevel;?>>

	<?php echo JText::_('COM_BABIOONEVENT_HEADTEXTSEARCH');?>

	<form action="index.php?option=com_babioonevent&view=event&layout=search&Itemid=<?php echo $Itemid;?>" method="post" name="adminForm" class="form-horizontal">
		<fieldset>
			<legend><?php echo JText::_('COM_BABIOONEVENT_ADDDATA');?></legend>

			<?php $displayData->label = $form->getLabel('fulltext'); ?>
			<?php $displayData->input = $form->getInput('fulltext'); ?>
			<?php echo FOFLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $displayData->label = $form->getLabel('s_isfreeofcharge'); ?>
			<?php $displayData->input = $form->getInput('s_isfreeofcharge'); ?>
			<?php echo FOFLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 's_sdate'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo FOFLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 's_edate'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo FOFLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'pcodefrom'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo FOFLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'pcodeupto'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo FOFLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'excatid'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php $displayData->removeRoot = true; ?>
			<?php $displayData->selectAll = true; ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo FOFLayoutHelper::render('form.categoriesselect', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

		</fieldset>

		<div class="note"><?php echo JText::_('COM_BABIOONEVENT_NOTESEARCHEVENT'); ?></div>

		<div class="form-actions">
			<input type="submit" value="<?php echo JText::_('COM_BABIOONEVENT_SEARCH');?>" class="btn btn-primary" />
		</div>

		<input type="hidden" name="option" value="com_babioonevent" />
		<input type="hidden" name="view" value="event" />
		<input type="hidden" name="task" value="sresult" />
		<input type="hidden" name="layout" value="sresult" />
		<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	</form>
</div>
<!-- *************************** END: babioonevent *************************** -->