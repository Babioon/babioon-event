<?php
/**
 * RDBS 
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: categoryselect.php 635 2009-08-23 12:57:09Z deutz $
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );

if ($this->elm ['error'] == 1) {
	echo '<div class="formelm fail">';
	echo '<p class="unsichtbar">' . JText::_ ( 'COM_BABIOONEVENT_FORMELMERROR' ) . '</p>';
	echo '<a name="error' . $this->errorcounter . '"></a>';
	$this->errorcounter ++;
} else {
	echo '<div class="formelm kategorie">';
}
if (array_key_exists('labletag',$this->elm))
{
	$namedesc = strtoupper ( $this->elm ['labletag'] );
} else {
	$namedesc = strtoupper ( $this->elm ['name'] ) . 'DESC';
}

echo JText::_ ( $namedesc );
echo $this->elm ['mandatory'] ? ' *' : '';
if ($this->elm ['value'] == 0) {
	$this->elm ['value'] = $this->elm['defaultvalue'];
}

echo '<select name="'.$this->elm['name'].'" class="inputbox">';
echo JHtml::_('select.options', JHtml::_('category.options', 'com_babioonevent'), 'value', 'text', $this->elm ['value']);
echo '</select>';

if ($this->elm ['error'] == 1 and $this->errorcounter < $this->errorcount) {
	echo '<a class="unsichtbar" href="#error' . $this->errorcounter . '">' . JText::_ ( 'COM_BABIOONEVENT_JUMPTONEXTERROR' ) . '</a>';
}
echo '<div class="wrap">&nbsp;</div> ';
echo '</div>';