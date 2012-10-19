<?php

/** ensure this file is being included by a parent file */
defined('BABIOON') or die('Restricted access');

/**
 * class BabioonLegacyDatePicker
 */
class BabioonLegacyDatePicker
{
	protected static $instance = null;


	function __construct()
	{
		$doc = JFactory:: getDocument();
		$doc->addScript('components/com_babioonevent/views/legacy/datepicker/js/datepicker.js');
		$doc->addStyleSheet('components/com_babioonevent/views/legacy/datepicker/css/datepicker.css');
	}

	function loadScript()
	{
		if (self::$instance === null)
		{
			self::$instance = new BabioonLegacyDatePicker();
		}
        
	}

	function getHtml(	$id,$datedefault='',$type='split-date',$rangeLow='',$rangeHigh='',
						$dText='TT',$mText='MM',$yText='YYYY',
						$lclassD='ldd',$lclassM='lmm',$lclassY='ldate',
						$classD='w2em',$classM='w2em',$classY='w4em',
						$disableDays='',
						$transparency=false
						)
	{
		// defaultvalue handling
		$day	= '';
		$month	= '';
		$year	= '';
		if ($datedefault != '')
		{
			// format: yyyy-mm-dd HH:MM
			$a = explode(' ',$datedefault);
			$b = explode('-',$a[0]);
			if (count($b) == 3)
			{
				$day	= $b[2];
				$month	= $b[1];
				$year	= $b[0];
			}
		}

		// transparency handling
		if (!$transparency) $classY .= ' no-transparency';
		// range low handling
		if ($rangeLow != '')
		{
			// format: yyyy-mm-dd
			$classY .= ' '.$rangeLow;
		}
		// range low handling
		if ($rangeHigh != '')
		{
			// format: yyyy-mm-dd
			$classY .= ' '.$rangeHigh;
		}
		// range low handling
		if ($disableDays != '')
		{
			// format: 12 -> daynumber start on monday
			$classY .= ' disable-days-12';
		}
		$classY .= ' '.$type;

 		echo '<label class="'.$lclassD.'" for="'.$id.'-dd">'.$dText.'</label>';
        echo '<input type="text" class="'.$classD.'" id="'.$id.'-dd" name="'.$id.'-dd" value="'.$day.'" maxlength="2" />';
		echo '<label class="'.$lclassM.'" for="'.$id.'-mm">'.$mText.'</label>';
		echo '<input type="text" class="'.$classM.'" id="'.$id.'-mm" name="'.$id.'-mm" value="'.$month.'" maxlength="2" />';
		echo '<label class="'.$lclassY.'" for="'.$id.'">'.$yText.'</label>';
		echo '<input type="text" class="'.$classY.'" id="'.$id.'" name="'.$id.'" value="'.$year.'" maxlength="4" />';
	}
}