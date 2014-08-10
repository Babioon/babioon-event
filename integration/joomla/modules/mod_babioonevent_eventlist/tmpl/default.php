<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

$showmonths 	= $params->get('showmonths', 0);
$showcats 		= $params->get('showcats', 1);
$order 			= $params->get('order', 1);
$headerlevel	= $params->get('headerlevel', 1);

if ($showmonths == 1)
{
	$mlevel = $headerlevel;

	if ($showcats)
	{
		$clevel = $mlevel + 1;
	}
}
else
{
	if ($showcats)
	{
		$clevel = $headerlevel;
	}
}

$month = '';
$scattext = '';
$close = '';

$rcount = count($items);

if (is_array($items) && $rcount != 0)
{

	echo '<div class="babiooneventmodule">';

	if ($showmonths == 0 && $showcats == 0)
	{
		echo '<ul class="liste">';
		$close = '</ul>';

	}

	for ($i = 0; $i < $rcount; $i ++)
	{
		$elm = $items [$i];

		if ($elm->mon != $month && $showmonths)
		{
			echo $close;
			$month = $elm->mon;
			$scattext = $elm->cctitle;
			echo '<h' . $mlevel . '>' . JText::_($month) . '</h' . $mlevel . '>';

			if ($showcats)
			{
				echo '<h' . $clevel . '>' . $scattext . '</h' . $clevel . '>';
			}
			echo '<ul class="liste">';
			$close = '</ul>';
		}
		else
		{
			if ($scattext != $elm->cctitle && $showcats)
			{
				echo $close;
				$scattext = $elm->cctitle;
				echo '<h' . $clevel . '>' . $scattext . '</h' . $clevel . '>';
				echo '<ul class="liste">';
				$close = '</ul>';
			}
		}
		echo '<li>';

		if ($elm->edate != '0000-00-00' && $elm->sdate != '0000-00-00')
		{
			// Start und ende angegeben
			$sd = date('d.m.Y', strtotime($elm->sdate));
			$ed = date('d.m.Y', strtotime($elm->edate));
			echo '<span class="date">';
			if ($sd == $ed)
			{
				echo $sd;
			}
			else
			{
				// Beide Tage ausgeben
				echo $sd,' - ', $ed;
			}
			echo ':</span> ';
		}
		else
		{
			if ($elm->sdate != '0000-00-00')
			{
					echo '<span class="date">' . date('d.m.Y', strtotime($elm->sdate));
					echo ':</span> ';
			}

		}
		echo '<a href="' . $elm->link . '">' . $elm->name . '</a>', '</li>';
	}
	echo $close;

	echo '</div>';
}
else
{
	echo JText::_('MOD_BABIONEVENT_NOEVENTS');
}
