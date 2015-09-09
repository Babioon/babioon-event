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
$slevel			= $headerlevel;

if ($this->params->get('show_page_heading'))
{
    $slevel			= $headerlevel + 1;
}

$slevel2		= $slevel + 1;
$this->slevel2  = $slevel2;
$Itemid 		= BabioonEventRouteHelper::getItemid('events');

$title = JLayoutHelper::render('html.title', $displayData, JPATH_ROOT . '/media/babioon/event/layouts');

$month	= '';
?>
<!-- ************************** START: babioonevent ************************** -->
<div class="babioonevent blocks">

    <?php if ($this->params->get('show_page_heading')) : ?>
        <h<?php echo $headerlevel;?> class="title">
            <?php echo $title;?>
        </h<?php echo $headerlevel;?>>
    <?php endif; ?>

	<div class="events">

		<?php if (empty($this->items)) : ?>
            <?php echo JText::_('COM_BABIOONEVENT_DEFAULTLISTNORESULT'); ?>
        <?php endif; ?>

        <?php if (!empty($this->items)) : ?>

			<?php foreach ($this->items AS $item) : ?>
                <?php $item_month = date('m', strtotime($item->sdate)); ?>
                <?php if ($month != $item_month) : ?>
                    <div class="month">
                        <h<?php echo $slevel;?>>
                            <?php echo JText::_(date('F', strtotime($item->sdate))) . ' ' . date('Y', strtotime($item->sdate)); ?>
                        </h<?php echo $slevel;?>>
                        <?php $month = $item_month; ?>
                    </div>
                <?php endif; ?>
                <div class="panel panel-default category-<?php echo $item->catid;?>">
                    <?php
                    $this->item = & $item;
                    echo $this->loadTemplate('item');
                    ?>
                </div><!-- end panel-default -->
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php echo $this->pagination->getPaginationLinks(); ?>
    </div>

</div>
<!-- *************************** END: babioonevent *************************** -->
