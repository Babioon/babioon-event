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
 * @since    2.0
 */
class BabioonEventViewEvents extends FOFViewRaw
{
	/**
	 * Default view, list of items
	 *
	 * @return  void
	 */
	public function display()
	{
		$doc    = JFactory::getDocument();
		$rows 	= $this->getModel()->getItemList();

		// Get feed titel params
		$feedtp = JRequest::getVar('feedtp', '');

		foreach ($rows as $row)
		{
			// Strip html from feed item title
			$title = $this->escape($row->name);

			// Url link to event
			// & used instead of &amp; as this is converted by feed creator
			$link = JRoute::_($row->link);

			// Strip html from feed item description text
			$description = $row->teaser;
			$author      = '';

			if (trim($row->organiser) != '')
			{
				$author	= $row->organiser;
			}

			$dedate = '';
			$date   = '';

			if ($row->stimeset)
			{
				$vdate  = $row->sdate . ' ' . $row->stime;
				$dedate = date('d.m.Y H:i', strtotime($vdate)) . ' - ';
				$date 	= date('r', strtotime($vdate));
			}
			else
			{
				if ($row->sdate != '0000-00-00')
				{
					$date 	= date('r', strtotime($row->sdate));
					$dedate = date('d.m.Y', strtotime($row->sdate)) . ' - ';
				}
			}

			// Load individual item creator class
			$item = new JFeedItem;

			if ($feedtp != '')
			{
				/*
				 * d = add date to title
				 * a = add address to title
				 * v = add ainfo,street, city to title
				 *
				 * order d - title - a - v
				 */

				if (strpos($feedtp, 'd') !== false)
				{
					$title = $dedate . $title;
				}

				if (strpos($feedtp, 'a') !== false)
				{
					$address = $row->address ? ' - ' . strip_tags($row->address) : '';
					$title = $title . $address;
				}

				if (strpos($feedtp, 'v') !== false)
				{
					$add  = '';
					$glue = '';

					if ($row->ainfo != '')
					{
						$add .= $row->ainfo;
						$glue = ', ';
					}

					if ($row->street != '')
					{
						$add .= $glue . $row->street;
						$glue = ', ';
					}

					if ($row->city != '')
					{
						$add .= $glue . $row->city;
					}

					if (trim($add) != '')
					{
						$add = ' - ' . $add;
					}

					$title = $title . $add;
				}
			}

			$title = html_entity_decode($title);
			$item->title 		= $title;
			$item->link 		= $link;
			$item->author		= $author;
			$item->description 	= $description;
			$item->date			= $date;
			$item->category   	= $row->cctitle;

			// Loads item info into rss array
			$doc->addItem($item);
		}
	}
}
