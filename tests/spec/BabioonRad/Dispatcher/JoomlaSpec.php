<?php

namespace spec\BabioonRad\Dispatcher;

use BabioonRad\Parser\Url;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JoomlaSpec extends ObjectBehavior
{

	function let(Url $url)
	{
		$this->beConstructedWith($url);
	}

	function it_is_initializable()
	{
		$this->shouldHaveType('BabioonRad\Dispatcher\Joomla');
	}

	function it_should_return_true_after_execution()
	{
		$this->execute()->shouldReturn(true);
	}

}
