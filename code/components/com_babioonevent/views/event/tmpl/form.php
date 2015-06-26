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
$errors 		= $form->getErrors();
$params 		= JComponentHelper::getParams('com_babioonevent');
$keys 			= array_keys($form->getFieldset());
$showlocation   = $params->get('showlocation', 2);
$headerlevel    = $params->get('headerlevel', 1);
$Itemid 		= BabioonEventRouteHelper::getItemid('event');

if ($form->getValue('sdate') == '0000-00-00')
{
	$form->setValue('sdate', '');
}

if ($form->getValue('edate') == '0000-00-00')
{
	$form->setValue('edate', '');
}

if ($showlocation == 5)
{
	$locatioinfo = JText::_('COM_BABIOONEVENT_LOCATIONINFOGOOGLE');
}
else
{
	$locatioinfo = JText::_('COM_BABIOONEVENT_LOCATIONINFO');
}

$title = JLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');

?>
<!-- ************************** START: babioonevent ************************** -->
<div class="babioonevent">

<?php if (count($errors) != 0)
{
	echo "<h$headerlevel>" . JText::_('COM_BABIOONEVENT_ERROR') . "</h$headerlevel>";


	$displayData->pretext = JText::_('COM_BABIOONEVENT_ERRORSUBMITEVENT');
	$displayData->errors = $errors;
	echo JLayoutHelper::render('form.error', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');
}
else
{
	echo "<h$headerlevel>" . $title . "</h$headerlevel>";
	echo JText::_('COM_BABIOONEVENT_HEADTEXTSUBMITEVENT');
}

?>

	<?php echo JText::_('COM_BABIOONEVENT_ADDDATAINFO');?>


	<form action="index.php?option=com_babioonevent&view=event&Itemid=<?php echo $Itemid;?>" method="post" name="adminForm" class="form-horizontal">
		<fieldset>
			<legend><?php echo JText::_('COM_BABIOONEVENT_ADDDATA');?></legend>


			<?php $displayData->label = $form->getLabel('name'); ?>
			<?php $displayData->input = $form->getInput('name'); ?>
			<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'organiser'; ?>
			<?php if (in_array($f, $keys)) : ?>

				<?php $displayData->label = $form->getLabel($f); ?>
				<?php $displayData->input = $form->getInput($f); ?>
				<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
			<?php endif; ?>

		</fieldset>

		<fieldset>
			<legend><?php echo JText::_('COM_BABIOONEVENT_START');?></legend>
			<?php echo JText::_('COM_BABIOONEVENT_STARTINFO'); ?>

			<?php $f = 'sdate'; ?>
			<?php $displayData->label = $form->getLabel($f); ?>
			<?php $displayData->input = $form->getInput($f); ?>
			<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

			<?php $f = 'stimehh'; ?>
			<?php if (in_array($f, $keys)) : ?>

				<div class="formelement">
					<span class="control-label"><?php echo $form->getLabel($f); ?> / <?php echo $form->getLabel('stimemm'); ?></span>
					<div class="controls">
						<?php echo $form->getInput($f); ?><?php echo $form->getInput('stimemm'); ?>
					</div>
				</div>

			<?php endif; ?>
		</fieldset>


		<?php $f = 'edate'; ?>
		<?php if (in_array($f, $keys)) : ?>
			<fieldset>
				<legend><?php echo JText::_('COM_BABIOONEVENT_END');?></legend>
				<?php echo JText::_('COM_BABIOONEVENT_ENDINFO'); ?>

				<?php $f = 'edate'; ?>
				<?php $displayData->label = $form->getLabel($f); ?>
				<?php $displayData->input = $form->getInput($f); ?>
				<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

				<?php $f = 'etimehh'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<div class="formelement">
						<span class="control-label"><?php echo $form->getLabel($f); ?> / <?php echo $form->getLabel('etimemm'); ?></span>
						<div class="controls">
							<?php echo $form->getInput($f); ?><?php echo $form->getInput('etimemm'); ?>
						</div>
					</div>
				<?php endif; ?>

			</fieldset>
		<?php endif; ?>

		<?php $f = array('contact','email','tel','website'); ?>
		<?php if (count(array_intersect($f, $keys)) != 0) : ?>
			<fieldset>
				<legend><?php echo JText::_('COM_BABIOONEVENT_CONTACTPERSON');?></legend>
				<?php echo JText::_('COM_BABIOONEVENT_CONTACTPERSONINFO'); ?>

				<?php $f = 'contact'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'tel'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'website'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'email'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'showemail'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>
			</fieldset>
		<?php endif; ?>

		<?php $f = array('ainfo','street','pcode','city','state','country'); ?>
		<?php if (count(array_intersect($f, $keys)) != 0) : ?>
			<fieldset>
				<legend><?php echo JText::_('COM_BABIOONEVENT_LOCATION');?></legend>
				<?php echo $locatioinfo; ?>

				<?php $f = 'address'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'ainfo'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'street'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'pcode'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'city'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'state'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'country'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

			</fieldset>
		<?php endif; ?>


		<?php $f = array('address','teaser','text','isfreeofcharge','charge','catid'); ?>
		<?php if (count(array_intersect($f, $keys)) != 0) : ?>
			<fieldset>
				<legend><?php echo JText::_('COM_BABIOONEVENT_EVENTDESCRIPTION');?></legend>
				<?php echo JText::_('COM_BABIOONEVENT_EVENTDESCRIPTIONINFO'); ?>

				<?php $f = 'address'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'teaser'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'text'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'isfreeofcharge'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'charge'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>

				<?php $f = 'catid'; ?>
				<?php if (in_array($f, $keys)) : ?>
					<?php $displayData->label = $form->getLabel($f); ?>
					<?php $displayData->input = $form->getInput($f); ?>
					<?php echo JLayoutHelper::render('form.formelement', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
				<?php endif; ?>
			</fieldset>

		<?php endif; ?>



		<div class="note"><?php echo JText::_('COM_BABIOONEVENT_NOTESUBMITEVENT'); ?></div>

		<div class="form-actions">
			<input type="submit" value="<?php echo JText::_('COM_BABIOONEVENT_SEND');?>" class="btn btn-primary" />
		</div>

		<input type="hidden" name="option" value="com_babioonevent" />
		<input type="hidden" name="view" value="event" />
		<input type="hidden" name="task" value="preview" />
		<input type="hidden" name="layout" value="preview" />
		<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	</form>
</div>
<!-- *************************** END: babioonevent *************************** -->