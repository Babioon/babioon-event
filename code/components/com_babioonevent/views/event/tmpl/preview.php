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

$displayData 	 = new stdClass;
$form 			 = $this->form;
$params 		 = JComponentHelper::getParams('com_babioonevent');
$keys 			 = array_keys($form->getFieldset());
$showlocation    = $params->get('showlocation', 2);
$headerlevel     = $params->get('headerlevel', 1);
$subheaderlevel  = $headerlevel + 1;
$subheaderlevel2 = $headerlevel + 2;
$Itemid 		 = BabioonEventRouteHelper::getItemid('event');

$fields 		 = array('tel','website','ainfo','street','pcode','city','state','country','address','teaser','text');
?>
<!-- **************** start event **************** -->
<div class="babioonevent">

	<h<?php echo $headerlevel;?>>
		<?php echo JText::_('COM_BABIOONEVENT_CHECKDATA');?>
	</h<?php echo $headerlevel;?>>
	<?php echo JText::_('COM_BABIOONEVENT_HEADTEXTSUBMITPAGE');?>

	<h<?php echo $subheaderlevel;?>>
		<?php echo JText::_('COM_BABIOONEVENT_EVENTDATA');?>
	</h<?php echo $subheaderlevel;?>>


	<?php $displayData->form = $form; ?>

	<?php $displayData->fieldname = 'name'; ?>
	<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

	<?php $f = 'organiser'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'sdate'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'stime'; ?>
	<?php if (in_array($f . 'hh', $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
			<?php echo FOFLayoutHelper::render('form.showtime', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'edate'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'etime'; ?>
	<?php if (in_array($f . 'hh', $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
			<?php echo FOFLayoutHelper::render('form.showtime', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'contact'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'email'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php if (trim($form->getValue('email')) != '') : ?>
		<?php $f = 'showemail'; ?>
		<?php if (in_array($f, $keys)) : ?>
			<?php $displayData->fieldname = $f; ?>
			<?php echo FOFLayoutHelper::render('form.showemail', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php foreach ($fields as $f) : ?>
		<?php if (in_array($f, $keys)) : ?>
			<?php $displayData->fieldname = $f; ?>
			<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
		<?php endif; ?>
	<?php endforeach; ?>

	<?php $f = 'isfreeofcharge'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showisfreeofcharge', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>

		<?php if ($form->getValue('isfreeofcharge') == 0) : ?>
			<?php $f = 'charge'; ?>
				<?php $displayData->fieldname = $f; ?>
				<?php echo FOFLayoutHelper::render('form.showvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php $f = 'catid'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo FOFLayoutHelper::render('form.showcategory', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>


	<div class="form-actions">

		<form action="index.php?option=com_babioonevent&view=event&Itemid=<?php echo $Itemid;?>" method="post" name="adminForm" class="float-left">

			<input type="submit" value="<?php echo JText::_('COM_BABIOONEVENT_SEND');?>" class="btn btn-primary" />

			<input type="hidden" name="option" value="com_babioonevent" />
			<input type="hidden" name="view" value="event" />
			<input type="hidden" name="task" value="save" />
			<input type="hidden" name="layout" value="presubmit" />
			<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

		</form>

		<form action="index.php?option=com_babioonevent&view=event&Itemid=<?php echo $Itemid;?>" method="post" name="adminForm" class="float-right">

			<input type="submit" value="<?php echo  JText::_('COM_BABIOONEVENT_CHANGE');?>" class="btn btn-warning" />

			<input type="hidden" name="option" value="com_babioonevent" />
			<input type="hidden" name="view" value="event" />
			<input type="hidden" name="task" value="change" />
			<input type="hidden" name="layout" value="presubmit" />
			<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

		</form>

	</div>
</div>
<!-- **************** end event **************** -->