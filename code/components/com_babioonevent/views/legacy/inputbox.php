<?php
/**
 * RDBS 
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: inputbox.php 669 2009-08-24 13:46:49Z deutz $
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );

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
echo '<label for="', $this->elm ['name'], '" class="lib" >', JText::_ ( $namedesc );
echo $this->elm ['mandatory'] ? ' *' : '';
echo ' </label>';

echo '<div class="field">';
echo '<input type="text" name="', $this->elm ['name'], '" id="', $this->elm ['name'], '" size="30" maxlength="100" class="inputbox" value="', $this->escape($this->elm ['value']), '" />';
echo '</div>';
if ($this->elm ['error'] == 1 and $this->errorcounter < $this->errorcount) {
	echo '<a class="unsichtbar" href="#error' . $this->errorcounter . '">' . JText::_ ( 'COM_BABIOONEVENT_JUMPTONEXTERROR' ) . '</a>';
}
echo '<div class="wrap">&nbsp;</div> ';
echo '</div>';