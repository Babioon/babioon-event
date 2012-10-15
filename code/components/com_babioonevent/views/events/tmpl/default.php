<?php
/**
 * babioon koorga
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 * @package BABIOON_KOORGA
 **/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

$pageclass_sfx=$this->params->get('pageclass_sfx','');
$subheaderlevel= $this->headerlevel;
?>

<div id="event<?php echo $pageclass_sfx;?>">

<?php 

if ($this->title != '')
{
	echo "<h$this->headerlevel>".$this->title."</h$this->headerlevel> \n";
	$subheaderlevel= $this->headerlevel+1;
}

echo "#<div style='text-align:left;font_size:1.2em;'><pre>";
print_r($this);
echo "</pre></div>#";



?>
</div> <!-- id=event -->