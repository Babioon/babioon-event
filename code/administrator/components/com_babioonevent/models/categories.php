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
 * BabiooneventModelCategories
 *
 * @package  BABIOON_EVENT
 * @since    3.1.1
 */
class BabiooneventModelCategories extends FOFModel
{
	/**
	 * Method to get a list of items.
	 *
	 * @param   boolean  $overrideLimits  Should I override set limits?
	 * @param   string   $group           The group by clause
	 *
	 * @return  array
	 */
	public function &getItemList($overrideLimits = false, $group = '')
	{
		$categories = $this->getCategories();
		$items = array();

		foreach ($categories as $key => $category)
		{
			$item = new StdClass;

			$item->value = $key;
			$item->text  = $category->title;

			$items[] = $item;
		}

		return $items;
	}

	/**
	 * get the event component categories
	 *
	 * @return  mixed
	 */
	public function getCategories()
	{
		$db 		= $this->getDbo();
		$query = $db->getQuery(true);

		$query->select("*")
			->from("#__categories")
			->where('extension = "com_babioonevent"')
			->order('lft');
		$db->setQuery($query);

		return $db->loadObjectList('id');
	}
}
