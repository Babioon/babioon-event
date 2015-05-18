<?php
/**
 * @*@*@-Projecthead-@*@*@
 */

namespace BabioonRad\Dispatcher;

use BabioonRad\Exception\ApplicationEnvironmentException;

/**
 * Class Joomla
 * @package BabioonRad\Dispatcher
 */
class Joomla extends Dispatcher
{
	/**
	 * @param $app
	 * @return bool
	 */
	public function execute($app)
	{
		echo $app->getAdmin();

		return true;
	}


}
