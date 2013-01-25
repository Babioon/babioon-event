<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die ('Restricted access');

$pageclass_sfx=$this->params->get('pageclass_sfx','');

$csvfile=$this->files[0] ;
$txtfile=$this->files[1] ;

?>

<div id="event<?php echo $pageclass_sfx;?>">
<?php
echo "<h$this->headerlevel>".JText::_('COM_BABIOONEVENT_EXPORTRESULT')."</h$this->headerlevel>";

$this->document->setTitle ( JText::_ ( 'COM_BABIOONEVENT_EXPORTRESULT_PT' ) );

if (trim($csvfile) == '' && trim($txtfile) == '')
{
        echo JText::_('COM_BABIOONEVENT_EXPORTFAIL');
}
else
{
    echo '<div>';
    echo JText::_('COM_BABIOONEVENT_EXPORTINTRO');
    if (trim($csvfile) != '')
    {
    	echo '<p><a class="readon" href="'.$csvfile.'">'.JText::_('COM_BABIOONEVENT_EXPORTDLLINK').'</a></p>';
    }
    if (trim($txtfile) != '')
    {
    	echo '<p><a class="readon" href="'.$txtfile.'">'.JText::_('COM_BABIOONEVENT_EXPORTDLLINK1').'</a></p>';
    }
    echo '</div>';
}

?>
</div> <!-- id=event -->