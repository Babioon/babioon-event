<?php
defined('_JEXEC') or die;

$id = $this->item->babioonevent_event_id;
$item = $this->item;
$booking_pad = '';
?>

<div class="panel-heading<?php echo $booking_pad;?>" role="tab" id="heading<?php echo $id; ?>">

    <div class="row trenner">
        <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6 first">
            <div class="calendar">
                <p class="daynum">
                    <?php echo date('d', strtotime($item->sdate));?>
                </p>
                <p class="dayname">
                    <?php echo JText::_(date('l', strtotime($item->sdate)));?>
                </p>
            </div>
            <div class="category">
                <?php echo $item->category_title; ?>
                <?php if (trim($item->customfield1) != '') : ?>
                    <br /><a href="<?php echo $item->customfield1;?>" class="btn btn-booking" target="_blank">
                        Buchen
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6 second">
            <a href="<?php echo $item->link; ?>">
                <h<?php echo $this->slevel2; ?> class="panel-title">
                    <?php echo $item->name; ?>
                </h<?php echo $this->slevel2; ?>>
            </a>
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $id; ?>">
                <div class="subtext">
                    <?php echo $item->teaser; ?>
                    Beginn: <?php echo date('d.m.y', strtotime($item->sdate)); ?>
                    <?php if($item->stimeset == 1) : ?>
                        &nbsp;<?php echo substr($item->stime, 0, 5); ?>&nbsp;Uhr
                    <?php endif; ?>
                    <?php if($item->edate != '0000-00-00') : ?><br />Ende:
                        <?php if($item->edate != $item->sdate) : ?>
                            <?php echo date('d.m.y', strtotime($item->edate)); ?>
                        <?php endif; ?>
                        <?php if($item->etimeset == 1) : ?>
                            &nbsp;<?php echo substr($item->etime, 0, 5); ?>&nbsp;Uhr
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($item->isfreeofcharge == 1) : ?>
                        <br />im Eintritt inbegriffen
                    <?php else: ?>
                        <br /><?php echo $item->charge; ?>
                    <?php endif; ?>
                </div>
            </a>
        </div>
    </div>


</div>
<div id="collapse<?php echo $id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $id; ?>">
    <div class="panel-body">
        <?php echo $item->text; ?>
    </div>
</div>

