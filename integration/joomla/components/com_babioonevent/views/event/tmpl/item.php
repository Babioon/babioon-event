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

if ($form->getValue('sdate') == '0000-00-00')
{
	$form->setValue('sdate', '');
}

if ($form->getValue('edate') == '0000-00-00')
{
	$form->setValue('edate', '');
}

$title 			 = JLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');
$fields 		 = array('tel','website','ainfo','street','pcode','city','state','country','address','teaser','text');
?>
<!-- **************** start event **************** -->
<div class="babioonevent">


	<h<?php echo $headerlevel;?>>
		<?php echo $title;?>
	</h<?php echo $headerlevel;?>>

	<h<?php echo $subheaderlevel;?>>
		<?php echo JText::_('COM_BABIOONEVENT_EVENTDETAIL');?>
	</h<?php echo $subheaderlevel;?>>

	<h<?php echo $subheaderlevel;?>>
		<?php echo $form->getValue('name');?>
	</h<?php echo $subheaderlevel;?>>


	<?php $displayData->form = $form; ?>

	<?php $f = 'organiser'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo JLayoutHelper::render('form.showsetvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'sdate'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo JLayoutHelper::render('form.showsetvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'stime'; ?>
	<?php if (in_array($f . 'hh', $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo JLayoutHelper::render('form.showsettime', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'edate'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo JLayoutHelper::render('form.showsetvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'etime'; ?>
	<?php if (in_array($f . 'hh', $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo JLayoutHelper::render('form.showsettime', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php $f = 'contact'; ?>
	<?php if (in_array($f, $keys)) : ?>
		<?php $displayData->fieldname = $f; ?>
		<?php echo JLayoutHelper::render('form.showsetvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>

	<?php if ($form->getValue('showemail') == 1) : ?>
		<?php $f = 'email'; ?>
		<?php if (in_array($f, $keys)) : ?>
			<?php $displayData->fieldname = $f; ?>
			<?php echo JLayoutHelper::render('form.showsetvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php foreach ($fields as $f) : ?>
		<?php if (in_array($f, $keys)) : ?>
			<?php $displayData->fieldname = $f; ?>
			<?php echo JLayoutHelper::render('form.showsetvalue', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
		<?php endif; ?>
	<?php endforeach; ?>

	<?php if ($form->getValue('isfreeofcharge') == 0) : ?>
		<?php $f = 'charge'; ?>
		<?php if (in_array($f, $keys)) : ?>
			<?php $displayData->fieldname = $f; ?>
			<?php echo JLayoutHelper::render('html.showcharge', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
		<?php endif; ?>

	<?php else : ?>
			<?php echo JLayoutHelper::render('html.showfreeofcharge', $displayData, JPATH_ROOT . '/media/babioon/event/layouts'); ?>
	<?php endif; ?>



</div>
<!-- **************** end event **************** -->