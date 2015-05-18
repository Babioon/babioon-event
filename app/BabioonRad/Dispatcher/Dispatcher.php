<?php
/**
 * @*@*@-Projecthead-@*@*@
 */

namespace BabioonRad\Dispatcher;

use BabioonRad\Parser\Url;

/**
 * Class Dispatcher
 * @package BabioonRad\Dispatcher
 */
abstract class Dispatcher implements DispatcherInterface {

	/**
	 * @var controller
	 */
	protected $controller;

	/**
	 * @var Url
	 */
	protected $urlParser;

	/**
	 * @param Url $urlParser
	 */
	public function __construct(Url $urlParser)
	{
		$this->urlParser = $urlParser;
	}

    /**
     * @return mixed
     */
    public function execute($app)
    {
        return true;
    }

	/**
	 * @param $name
	 */
	protected function setController($name)
    {

    }

	/**
	 * @return controller
	 */
	public function getController()
    {
		return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAppenv()
    {
        return $this->appenv;
    }
}
