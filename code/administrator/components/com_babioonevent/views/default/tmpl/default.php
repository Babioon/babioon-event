<?php

if (JFactory::getUser()->authorise('core.admin', 'com_babioonevent'))
{
	echo JText::_('COM_BABIOONEVENT_CONFHERE_IMG');
}
echo JText::_('COM_BABIOONEVENT_COMP');
echo JText::_('COM_BABIOONEVENT_COMP_DESC');

echo '<div class="cpanel" style="padding:20px">';
echo JText::_('COM_BABIOONEVENT_COMP_SUPPORT');
echo JText::_('COM_BABIOONEVENT_COMP_DOCS');
echo JText::_('COM_BABIOONEVENT_COMP_FORUM');
if (JFactory::getUser()->authorise('core.admin', 'com_babioonevent'))
{
	echo LiveUpdate::getIcon();
}


echo '</div>';
echo '<div class="clr"></div>';

echo '<p>' . JText::_('COM_BABIOONEVENT_COPYRIGHT') . ' | ';
echo JText::_('COM_BABIOONEVENT_LICENSE') . '</p>';
