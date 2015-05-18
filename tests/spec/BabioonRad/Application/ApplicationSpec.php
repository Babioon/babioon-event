<?php

namespace spec\BabioonRad\Application;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationSpec extends ObjectBehavior
{

	function let()
    {
        $config = ['appenv' => 'joomla'];
        $this->beConstructedWith($config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BabioonRad\Application\Application');
    }

    function it_should_return_joomla_as_appenv()
    {
        $this->getAppenv()->shouldReturn('joomla');
    }

	function it_should_register_base_bindings()
	{
		$this->getBindings()->shouldNotBe([]);
	}
}
