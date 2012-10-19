<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!class_exists('BabioonLegacyDatePicker',false)) 
{
    require_once dirname(__FILE__).'/datepicker/datepicker.php';
    BabioonLegacyDatePicker::loadScript();    
}

if ($this->elm ['error'] == 1) {
	echo '<div class="formelm fail">';
	echo '<p class="unsichtbar">' . JText::_ ( 'COM_BABIOONEVENT_FORMELMERROR' ) . '</p>';
	echo '<a name="error' . $this->errorcounter . '"></a>';
	$this->errorcounter ++;
} else {
	echo '<div class="formelm">';
}
if (array_key_exists('labletag',$this->elm))
{
	$namedesc = strtoupper ( $this->elm ['labletag'] );
} else {
	$namedesc = strtoupper ( $this->elm ['name'] ) . 'DESC';
}
echo '<label for="', $this->elm ['name'], '" class="slib" >', JText::_ ( $namedesc );
echo $this->elm ['mandatory'] ? ' *' : '';
echo ' </label>';
if ($this->elm ['value'] == '0000-00-00') $this->elm ['value'] = '';
BabioonLegacyDatePicker::getHtml ( $this->elm ['name'], $this->elm ['value'],'split-date','','',JText::_('TT'),JText::_('MM'),JText::_('YYYY') );

if ($this->elm ['error'] == 1 and $this->errorcounter < $this->errorcount) {
	echo '<a class="unsichtbar" href="#error' . $this->errorcounter . '">' . JText::_ ( 'COM_BABIOONEVENT_JUMPTONEXTERROR' ) . '</a>';
}
echo '<div class="wrap">&nbsp;</div> ';
echo '</div>';
