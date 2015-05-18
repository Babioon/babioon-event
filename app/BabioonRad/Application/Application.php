<?php
/**
 * @*@*@-Projecthead-@*@*@
 */

namespace BabioonRad\Application;

use BabioonRad\Dispatcher\DispatcherInterface;
use BabioonRad\Exception\ApplicationEnvironmentException;
use Illuminate\Container\Container;

/**
 * Class Application
 * @package BabioonRad\Application
 */
class Application extends Container
{
    /**
     * @string
     */
    protected $appenv;

	/**
	 * @var mixed
	 */
	protected $dispatcher;

	/**
	 * @var
	 */
	protected $admin;

	/**
	 * @var
	 */
	protected $input;

	/**
     * @param array $config
     */
    public function __construct($config = [])
    {
		// bootstrap the application
		if (file_exists(__DIR__ . '/../../../start.php'))
		{
			require_once __DIR__ . '/../../../start.php';
		}

        if (array_key_exists('appenv',$config))
        {
            $this->appenv = $config['appenv'];
        }

		// set the IOC
		$this->registerBaseBindings();

		// set the IOC bindings
		$this->registerBindings();

		// set the IOC appenv bindings
		$this->registerAppenvBindings();

		// register alias
		$this->registerCoreContainerAliases();

		// setting up the dispatcher
	 	$this->dispatcher = $this->make('BabioonRad\Dispatcher\DispatcherInterface');

		// set if we are in admin area
		if (array_key_exists('admin',$config))
		{
			$this->admin = $config['admin'];
		}

		// set if we are in admin area
		if (array_key_exists('input',$config))
		{
			$this->input = $config['input'];
		}

	}

	/**
	 * @return mixed
	 * @throws \BabioonRad\Exception\ApplicationEnvironmentException
	 */
	public function execute()
	{
		if ($this->dispatcher instanceof DispatcherInterface)
		{
			return $this->dispatcher->execute($this);
		}

		throw new ApplicationEnvironmentException('Could not execute the dispatcher');
	}

	/**
	 * Register appenv Bindings
	 *
	 * @return void
	 */
	protected function registerAppenvBindings()
	{
		$this->bind('BabioonRad\Dispatcher\DispatcherInterface', 'BabioonRad\Dispatcher\Joomla');
	}

	/**
	 * Register Bindings
	 *
	 * @return void
	 */
	public function registerBindings()
	{
		//$this->bind('', '');
	}
	/**
	 * Register the basic bindings into the container.
	 *
	 * @return void
	 */
	protected function registerBaseBindings()
	{
		$this->instance('Illuminate\Container\Container', $this);
	}

	/**
	 * Register the core class aliases in the container.
	 *
	 * @return void
	 */
	public function registerCoreContainerAliases()
	{
		$aliases = array(
			'app'            => 'BabioonRad\Application\Application'
		);

		foreach ($aliases as $key => $alias)
		{
			$this->alias($key, $alias);
		}
	}

	/**
	 * Determine if we are running in the console.
	 *
	 * @return bool
	 */
	public function runningInConsole()
	{
		return php_sapi_name() == 'cli';
	}

    /**
     * @return mixed
     */
    public function getAppenv()
    {
        return $this->appenv;
    }

	/**
	 * @return mixed
	 */
	public function getDispatcher()
	{
		return $this->dispatcher;
	}

	/**
	 * @return mixed
	 */
	public function getAdmin()
	{
		return $this->admin;
	}

	/**
	 * @return mixed
	 */
	public function getInput()
	{
		return $this->input;
	}
}
