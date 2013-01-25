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
 * BabioonEventRouteHelper
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventRouteHelper
{
	/**
	 * get the item id
	 *
	 * @param   string  $type  type
	 *
	 * @return int             itemid
	 */
	public static function getItemid($type="default")
	{
		$result = null;
		$app    = JFactory::getApplication();

		switch ($type)
		{
			case "events":
				$result = $app->getMenu()
								->getItems('link', 'index.php?option=com_babioonevent&view=events', true);
				break;
		}

		$result = is_object($result) ? $result->id : $app->input->get('Itemid', 0, 'uint');

		return $result;
	}
}
