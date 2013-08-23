<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;

/**
 * BabioonEventHelper
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventHelper
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 */
	protected static $text_prefix = 'COM_BABIOONEVENT_';

	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 */
	public static function addSubmenu($vName)
	{
		$submenu = array('default','events');
		$classSidebar = 'JSubMenuHelper';

		if (self::isVersion3())
		{
			$classSidebar = 'JHtmlSidebar';
		}

		foreach ($submenu AS $item)
		{
			$classSidebar::addEntry(
				JText::_(self::$text_prefix . strtoupper($item)),
				'index.php?option=com_babioonevent&view=' . $item,
				$vName == $item
			);
		}

		$classSidebar::addEntry(
			JText::_('COM_BABIOONEVENT_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_babioonevent',
			$vName == 'categories'
		);

		if (JFactory::getUser()->authorise('core.admin', 'com_babioonevent'))
		{
			$classSidebar::addEntry(
				JText::_(self::$text_prefix . strtoupper('liveupdate')),
				'index.php?option=com_babioonevent&view=liveupdate',
				$vName == 'liveupdate'
			);
		}

		if ($vName == 'categories')
		{
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_babioonevent')),
				'babioonevent-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		$assetName = 'com_babioonevent';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * return the singular to a in plural given object name
	 *
	 * @param   string  $plural  the plural
	 *
	 * @return  string the singular
	 */
	public static function toSingular($plural)
	{
		$singular = '';

		switch ($plural)
		{
			case 'events' :
				$singular = 'event';
				break;
		}

		return $singular;
	}

	/**
	 * Checks if we are running a Joomla-Version greater or equal 3.0
	 *
	 * @return  boolean
	 */
	public static function isVersion3()
	{
		return version_compare(JVERSION, '3.0', 'ge');
	}
}
