<?php
/**
 * RDBS
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: error.php 635 2009-08-23 12:57:09Z deutz $
 **/

defined ('_JEXEC') or die ('Restricted access');

$this->document->addScript('media/plg_rdbs/js/rdbs.js');

echo "\n".'<div class="rdevent_error">';
echo '<h'.$this->headerlevel.'>'.$this->title.'</h'.$this->headerlevel.'>';
echo $this->preerrortext;
echo "\n".'<ul class="form_error">';
$this->errorcount = count ( $this->error );
foreach ( $this->error as $elm ) {
	echo "\n"."<li>$elm</li>";
}
echo "\n"."</ul>";
echo '<p><a href="#error1" onclick="failfind(0); return false">' . JText::_ ( 'COM_BABIOONEVENT_JUMPTOFIRSTERROR' ) . '</a></p>';

$this->errorcounter = 1;
echo "\n". '</div>';