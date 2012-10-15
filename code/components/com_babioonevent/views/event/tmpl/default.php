<?php
/**
 * babioon koorga
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_KOORGA
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

$pageclass_sfx   = $this->params->get('pageclass_sfx','');
$subheaderlevel  = $this->headerlevel+1;
$subheaderlevel2 = $this->headerlevel+2; 
$subheaderlevel3 = $this->headerlevel+3; 
$data=$this->element;
?>

<div id="event<?php echo $pageclass_sfx;?>">
	<h<?php echo $this->headerlevel;?>><?php echo $this->title;?></h<?php echo $this->headerlevel;?>>

</div> <!-- id=event -->

<?php 
echo "#<div style='text-align:left;font_size:1.2em;'><pre>";
print_r($this);
echo "</pre></div>#";
?>