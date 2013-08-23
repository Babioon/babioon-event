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
 * BabioonEventView
 *
 * @package  BABIOON_EVENT
 * @since    3.0
 */
class BabioonEventView extends JViewLegacy
{
	/**
	 * Load a template file -- first look in the templates folder for an override
	 *
	 * @access	public
	 * @param string $tpl The name of the template source file ...
	 * automatically searches the template paths and compiles as needed.
	 * @param boolean add the layout as prefix to filename
	 * @return string The output of the the template script.
	 */
	function loadTemplate( $tpl = null, $addLayoutPrefix = true)
	{
		// clear prior output
		$this->_output = null;
		if ($addLayoutPrefix)
		{
			//create the template file name based on the layout
			$file = isset($tpl) ? $this->_layout.'_'.$tpl : $this->_layout;
		}
		else
		{
			// get the file name as it is
			$file = $tpl;
		}
		// clean the file name
		$file = preg_replace('/[^A-Z0-9_\.-]/i', '', $file);
		$tpl  = preg_replace('/[^A-Z0-9_\.-]/i', '', $tpl);

		// load the template script
		jimport('joomla.filesystem.path');
		$filetofind	= $this->_createFileName('template', array('name' => $file));
		$this->_template = JPath::find($this->_path['template'], $filetofind);

		if ($this->_template != false)
		{
			// unset so as not to introduce into template scope
			unset($tpl);
			unset($file);

			// never allow a 'this' property
			if (isset($this->this)) {
				unset($this->this);
			}

			// start capturing output into a buffer
			ob_start();
			// include the requested template filename in the local scope
			// (this will execute the view logic).
			include $this->_template;

			// done with the requested template; get the buffer and
			// clear it.
			$this->_output = ob_get_contents();
			ob_end_clean();

			return $this->_output;
		}
		else {
			return JError::raiseError( 500, 'Layout "' . $file . '" not found' );
		}
	}

	/**
	 * wrapper method for setting the page title
	 *
	 * @param string $title
	 */
	public function setPageTitle($title, $append = false, $appendString = ': ')
	{
		$doc         = RdbsFactory::getDocument();
		$newtitle    = $append ? $doc->getTitle() . $appendString . $title : $title;;
		$doc->setTitle($newtitle);
	}
}