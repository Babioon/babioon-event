<?php
/**
 * @*@*@-Projecthead-@*@*@
 */

namespace BabioonRad\Dispatcher;

interface DispatcherInterface {

	/**
	 * @param $app
	 * @return mixed
	 */
    public function execute($app);
} 