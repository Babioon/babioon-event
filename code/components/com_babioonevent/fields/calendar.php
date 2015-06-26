<?php
/**
 * @package     BabioonLibrary
 * @subpackage  FormField
 *
 * @author      Robert Deutz <rdeutz@googlemail.com>
 * @copyright   2015 Babioon
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_BASE') or die;

/**
 * Calendar Form Field class for Babioon Components.
 *
 * Provides a pop up date picker.
 *
 * @since  3.0.0
 */
class BabiooneventFormFieldCalendar extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	protected $type = 'Calendar';

	/**
	 * The format of date and time.
	 *
	 * @var    integer
	 * @since  3.0.0
	 */
	protected $format;

	/**
	 * first day of the week 1 == Monday, 0 == Sunday
	 *
	 * @var    integer
	 * @since  3.0.0
	 */
	protected $firstdayofweek = 0;

	/**
	 * save load state of the datepicker scripts
	 *
	 * @var    integer
	 * @since  3.0.0
	 */
	private static $scriptsLoaded = false;

	/**
	 * Set supported languages for this datepicker
	 *
	 * @var array
	 * @since  3.0.0
	 */
	protected $supportedLanguages = array('en', 'fr', 'jp', 'de');

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   3.0.0
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'firstdayofweek':
			case 'format':
			case 'language':
				return $this->$name;
		}

		return parent::__get($name);
	}

	/**
	 * Method to set certain otherwise inaccessible properties of the form field object.
	 *
	 * @param   string  $name   The property name for which to the the value.
	 * @param   mixed   $value  The value of the property.
	 *
	 * @return  void
	 *
	 * @since   3.0.0
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'firstdayofweek':
				$value = (int) $value;

			case 'format':
			case 'language':
				$this->$name = (string) $value;
				break;

			default:
				parent::__set($name, $value);
		}
	}

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     JFormField::setup()
	 * @since   3.0.0
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return)
		{
			$firstdayofweek = JFactory::getLanguage()->getFirstDay();

			if ( ! in_array($firstdayofweek, array(0,1)))
			{
				$firstdayofweek = 0;
			}

			$this->firstdayofweek = (int) $this->element['firstdayofweek'] ? (int) $this->element['firstdayofweek'] : $firstdayofweek;
			$this->format         = (string) $this->element['format'] ? (string) $this->element['format'] : '%Y-%m-%d';
			$this->language       = (string) $this->element['language'] ? (string) $this->element['language'] : 'en';
		}

		return $return;
	}

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.0.0
	 */
	protected function getInput()
	{
		$this->init();

		// Translate placeholder text
		$hint = $this->translateHint ? JText::_($this->hint) : $this->hint;

		// Initialize some field attributes.
		$format         = $this->format;
		$firstdayofweek = $this->firstdayofweek;

		// Build the attributes array.
		$attributes = array();

		empty($this->size)      ? null : $attributes['size'] = $this->size;
		empty($this->class)     ? null : $attributes['class'] = $this->class;
		!$this->readonly        ? null : $attributes['readonly'] = 'readonly';
		!$this->disabled        ? null : $attributes['disabled'] = 'disabled';
		empty($this->onchange)  ? null : $attributes['onchange'] = $this->onchange;
		empty($hint)            ? null : $attributes['placeholder'] = $hint;
		$this->autocomplete     ? null : $attributes['autocomplete'] = 'off';
		!$this->autofocus       ? null : $attributes['autofocus'] = '';

		if ($this->required)
		{
			$attributes['required'] = '';
			$attributes['aria-required'] = 'true';
		}

		$lang     = JFactory::getLanguage();
		$tag      = explode('-', $lang->getTag());
		$language = $tag[0];

		if (! in_array($language, $this->supportedLanguages))
		{
			$language = 'en';
		}

		$script = 'jQuery(document).ready(function($) {

					$("#' . $this->id . '").datepicker({
						dateFormat: "' . $format . '",
						language: "' . $language . '",
						firstDayOfWeek: ' . $firstdayofweek . '
					});
				});';

		$document = JFactory::getDocument();
		$document->addScriptDeclaration($script);

		$value = $this->value;

		$html = '<input type="text" id="' . $this->id . '" name="' . $this->name . '" value="' . $value . '" />';

		return  $html;
	}

	/**
	 * Init needed scripts
	 *
	 * @return  void
	 */
	private function init()
	{
		if ($this->scriptsLoaded)
		{
			return;
		}

		// Including needed javascripts
		JHtml::_('jquery.framework');

		$document = JFactory::getDocument();
		$document->addStyleSheet('media/babioon/event/css/tadaaapickr.css');
		$document->addScript('media/babioon/event/js/tadaaapickr.pack.min.js');
	}
}
