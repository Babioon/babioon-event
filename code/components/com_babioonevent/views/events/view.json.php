<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die ('Restricted access');

/**
 * BabioonEventViewEvents
 *
 * @package  BABIOON_EVENT
 * @since    3.0.2
 */
class BabioonEventViewEvents extends FOFViewJson
{
	public $useHypermedia = false;

	/**
	 * The event which runs when we are displaying the record list JSON view
	 *
	 * @param   string  $tpl  The view sub-template to use
	 *
	 * @return  boolean  True to allow display of the view
	 */
	protected function onDisplay($tpl = null)
	{
		$document = FOFPlatform::getInstance()->getDocument();

		if ($document instanceof JDocument)
		{
			$document->setMimeEncoding('application/json');
		}

		// Load the model
		$model = $this->getModel();

		$items      = $model->getItemList();
		$categories = $model->getCategories();

		$publicFields = array("babioonevent_event_id", "name", "organiser", "sdate", "stime", "stimeset",
								"edate", "etime", "etimeset", "contact", "tel", "website",
								"address", "ainfo", "street", "pcode", "city", "state", "country", "geo_b", "geo_l",
								"teaser", "text", "isfreeofcharge", "charge", "picturefile",
								"created", "modified",
								"customfield1", "customfield2", "customfield3", "customfield4", "link");
		$publicData   = array();

		foreach ($items as $item)
		{
			$data = array();

			foreach ($publicFields as $field)
			{
				$data[$field] = $item->$field;
			}

			$data['category'] = '';

			if (array_key_exists($item->catid, $categories))
			{
				$data['category'] = $categories[$item->catid]->title;
			}

			if ($item->showemail == 1)
			{
				$data['email'] = $item->email;
			}

			$publicData[] = $data;
		}

		$json = json_encode($publicData);

		echo $json;

		return false;
	}
}
