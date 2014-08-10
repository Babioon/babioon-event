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
		// Load FOF
		include_once JPATH_LIBRARIES . '/fof/include.php';

		if (!defined('FOF_INCLUDED'))
		{
			JError::raiseError('500', 'FOF is not installed');
		}

		if (self::isVersion3())
		{
			$strapper = new FOFRenderJoomla3;
		}
		else
		{
			$strapper = new FOFRenderJoomla;
		}

		$strapper->renderCategoryLinkbar('com_babioonevent');
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
	 * Checks if we are running a Joomla-Version greater or equal 3.0
	 *
	 * @return  boolean
	 */
	public static function isVersion3()
	{
		return version_compare(JVERSION, '3.0', 'ge');
	}

	/**
	 * Create a uniq filename, returns false if not found
	 *
	 * @param   string   $adir      directroy where we are going to save the file
	 * @param   string   $prefix    a prefix for the filename
	 * @param   string   $suffix    a suffix for the filename
	 * @param   boolean  $year      include year in filename
	 * @param   boolean  $month     include month in filename
	 * @param   boolean  $day       include day in filename
	 * @param   boolean  $hour      include hour in filename
	 * @param   boolean  $minutes   include minutes in filename
	 * @param   boolean  $seconds   include seconds in filename
	 * @param   int      $maxloops  how many attemts we do
	 *
	 * @return unknown
	 */
	public static function getFilename($adir, $prefix, $suffix, $year = false,$month=false,$day=true,$hour=true,$minutes=true,$seconds=true,$maxloops=10)
	{
		$filename = '';
		$format = '';

		if ($year)
		{
			$format .= 'Y';
		}

		if ($month)
		{
			$format .= 'm';
		}

		if ($day)
		{
			$format .= 'd';
		}

		if ($hour)
		{
			$format .= 'H';
		}

		if ($minutes)
		{
			$format .= 'i';
		}

		if ($seconds)
		{
			$format .= 's';
		}

		$loop = 0;
		$found = false;

		while (!$found  && ($loop < $maxloops))
		{
			$part = date($format);
			$filename = $prefix . '-' . $part . '.' . $suffix;
			$found = file_exists($adir . '/' . $filename) === false;
			$loop++;
		}

		if ($found)
		{
			return $filename;
		}

		return false;
	}

	/**
	 * converts html to text
	 *
	 * plain copy from php.net
	 *
	 * @param   string   $html       the html
	 * @param   boolean  $keeplinks  keep links within the text
	 *
	 * @return  string               the text
	 */
	public static function html2txt($html, $keeplinks=false)
	{
		$suche1 = array (
							'@<script[^>]*?>.*?</script>@si',   // JavaScript entfernen
							'@([\r\n])[\s]+@',                   // Leerraeume entfernen
							'@<br />@i',							// Zeilunbrueche
							'@</p>@i',							// Absaetze
							'@</tr>@i',							// Tabellenzeilen
							'@</td>@i'							// Tabellenspalten
						);

		$suche2 = array('');

		$suche3 = array (	'@<[\/\!]*?[^<>]*?>@si',             // HTML-Tags entfernen
							'@&(quot|#34);@i',                   // HTML-Entitaeten ersetzen
							'@&(amp|#38);@i',
							'@&(lt|#60);@i',
							'@&(gt|#62);@i',
							'@&(nbsp|#160);@i',
							'@&(iexcl|#161);@i',
							'@&(cent|#162);@i',
							'@&(pound|#163);@i',
							'@&(copy|#169);@i',
							'@&#(\d+);@e'                      // Als PHP auswerten
							);

		$ersetze1 = array (	'',
							'\1',
							chr(13),
							chr(13),
							chr(13),
							' | ');

		$ersetze3 = array('');

		$ersetze3 = array (	'',
							'"',
							'&',
							'<',
							'>',
							' ',
							chr(161),
							chr(162),
							chr(163),
							chr(169),
							'chr(\1)');

		if ($keeplinks)
		{
			$suche   = array_merge($suche1, $suche2, $suche3);
			$ersetze = array_merge($ersetze1, $ersetze2, $ersetze3);
		}
		else
		{
			$suche   = array_merge($suche1, $suche3);
			$ersetze = array_merge($ersetze1, $ersetze3);
		}

		$text = preg_replace($suche, $ersetze, $html);

		return $text;
	}
}
