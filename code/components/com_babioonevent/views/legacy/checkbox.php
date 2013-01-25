<?php
/**
 * RDBS
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: checkbox.php 635 2009-08-23 12:57:09Z deutz $
 **/
defined ('_JEXEC') or die ('Restricted access');

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
$checked = '';
if ($this->elm ['value'] == 1) {
	$checked = ' checked="checked"';
}
echo '<div class="field">';
echo '<input type="checkbox" name="', $this->elm ['name'], '" id="', $this->elm ['name'], '" class="cb" value="1"', $checked, ' />';
echo '</div>';

echo '<label for="', $this->elm ['name'], '" class="lcb" >', JText::_ ( $namedesc );
echo $this->elm ['mandatory'] ? ' *' : '';
echo '</label>';

if ($this->elm ['error'] == 1 and $this->errorcounter < $this->errorcount) {
	echo '<a class="unsichtbar" href="#error' . $this->errorcounter . '">' . JText::_ ( 'COM_BABIOONEVENT_JUMPTONEXTERROR' ) . '</a>';
}
echo '<div class="wrap">&nbsp;</div> ';
echo '</div>';