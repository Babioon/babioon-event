<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die ('Restricted access');

$pageclass_sfx  = $this->params->get('pageclass_sfx', '');
$subheaderlevel = $this->headerlevel;

$data = $this->defaultData;
?>

<div id="event<?php echo $pageclass_sfx;?>">

<?php

if ($this->title != '')
{
	echo "<h$this->headerlevel>" . $this->title . "</h$this->headerlevel> \n";
	$slevel = $this->headerlevel + 1;
}
$month	= '';
$close      = '';

echo '<div id="liste">';

if ( !empty($data))
{
        foreach ($data as $elm)
        {
                $emon = date('m',strtotime($elm->sdate));
                if ( $emon != $month )
                {
                        echo $close;
                        $month = $emon;
                        echo '<h'.$slevel.'>'.JText::_(date('F',strtotime($elm->sdate))).' '.date('Y',strtotime($elm->sdate)).'</h'.$slevel.'>';
                        echo '<ul class="liste">';
                        $close= '</ul>';
                }
                echo '<li>';

                if ($elm->edate != '0000-00-00' && $elm->sdate != '0000-00-00')
                {
                	//start und ende angegeben
                	$sd=date('d.m.Y',strtotime($elm->sdate));
                	$ed=date('d.m.Y',strtotime($elm->edate));
                	if ($sd == $ed)
                	{
                		echo $sd;
                	}
                	else
                	{
                		// beide Tage ausgeben
                		echo $sd,' - ', $ed;
                	}
                	echo ': ';
                }
                else
                {
					if ($elm->sdate != '0000-00-00')
					{
               			echo date('d.m.Y',strtotime($elm->sdate));
               			echo ': ';
					}

                }
                echo '<a href="'.$elm->link.'">'.$elm->name.'</a>','</li>';
        }
        echo $close;
}
else
{
	echo JText::_('COM_BABIOONEVENT_DEFAULTLISTNORESULT');
}
echo '</div>';
if ($this->showpagination)
{
	echo '<div class="pagination">';
    echo $this->dpage->getPagesLinks(  );
    echo '</div>';
}
?>
</div> <!-- id=event -->