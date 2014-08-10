<?php
/**
 * babioon
 * @package    BABIOON_GOOGLEMAPSV3
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;

/**
 * BabioonEventHelper
 *
 * @package  BABIOON_GOOGLEMAPSV3
 * @since    3.0
 * @uses map API v3
 */
class BabioonGooglemapsV3Helper
{
	/**
	 * [getGeoCoordinates description]
	 *
	 * @param   string  $street   street
	 * @param   string  $pcode    pcode
	 * @param   string  $city     city
	 * @param   string  $state    state
	 * @param   string  $country  country
	 *
	 * @return  mixed             false on error and array on success
	 */
	public function getGeoCoordinates($street, $pcode, $city, $state=null, $country=null)
	{
		$info 		= array();
		$search		= array(' ','-',',',';','ä','ö','ü','Ä','Ö','Ü','ß','++');
		$replace	= array('+','+','+','+','ae','oe','ue','Ae','Oe','Ue','ss','+');
		$info[]		= str_replace($search, $replace, $street);
		$info[]		= str_replace($search, $replace, $pcode);
		$info[]		= str_replace($search, $replace, $city);

		if (!is_null($state))
		{
			$info[] 	= str_replace($search, $replace, $state);
		}

		if (!is_null($country))
		{
			$info[] 	= str_replace($search, $replace, $country);
		}

		$istr			= implode('+', $info);
		$this->url		= 'http://maps.google.com/maps/api/geocode/json?address=' . $istr . '&sensor=false';

		$starttime	= time();
		$ch = curl_init();

		// Set url
		curl_setopt($ch, CURLOPT_URL, $this->url);

		// Return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$data = curl_exec($ch);

		if ($data === false)
		{
			$error = curl_error($ch);
			curl_close($ch);

			return false;
		}

		// Close curl resource to free up system resources
		curl_close($ch);

		$data = json_decode($data);

		if ($data->status == 'OK')
		{
			$location = $data->results[0]->geometry->location;
			$geo_b    = $location->lat;
			$geo_l    = $location->lng;
		}
		else
		{
			return false;
		}

		return (array($geo_l,$geo_b));
	}
}
