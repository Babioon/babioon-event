<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * class BabioonEventViewDefault
 *
 * @package  BABIOON_EVENT
 * @since    3.0
 */
class BabioonEventViewDefault extends FOFViewHtml
{
	/**
	 * default class construtor
	 *
	 * @param   array  $config  Configuration array
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		if (BabioonEventHelper::isVersion3())
		{
			// Joomla! 3.x
			$renderer = new FOFRenderJoomla3;
		}
		else
		{
			// Joomla! 2.5
			$renderer = new FOFRenderJoomla;
		}

		$this->setRenderer($renderer);
	}
}
