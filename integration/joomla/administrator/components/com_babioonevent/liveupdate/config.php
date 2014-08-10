<?php
/**
 * @package LiveUpdate
 * @copyright Copyright ©2011-2013 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 */

defined('_JEXEC') or die();

/**
 * Configuration class for your extension's updates. Override to your liking.
 */
class LiveUpdateConfig extends LiveUpdateAbstractConfig
{
	var $_extensionName			= 'com_babioonevent';
	var $_extensionTitle		= 'Babioon Event';
	var $_updateURL				= 'http://babioon.com/index.php?option=com_ars&view=update&format=ini&id=3';
	var $_requiresAuthorization	= false;
	var $_versionStrategy		= 'different';

	public function __construct() {
		JLoader::import('joomla.filesystem.file');

		$this->_extensionTitle		= JText::_('COM_BABIOONEVENT');

		// Should I use our private CA store?
		if(@file_exists(dirname(__FILE__).'/../assets/cacert.pem')) {
			$this->_cacerts = dirname(__FILE__).'/../assets/cacert.pem';
		}

		parent::__construct();
	}
}