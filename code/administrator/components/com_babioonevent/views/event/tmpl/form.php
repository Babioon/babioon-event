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
?>
<!-- **************** start event **************** -->
<div class="babioonevent">
<?php
$viewTemplate = $this->getRenderedForm();
echo $viewTemplate;
?>
</div>
<!-- **************** end event **************** -->