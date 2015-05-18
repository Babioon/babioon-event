<?php

namespace spec\BabioonRad\Parser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BabioonRad\Parser\Url');
    }

	function it_parses_a_url_and_return_query_as_array()
	{
		$this->parse('index.php')->shouldReturn([]);

		$this->
			parse('index.php?option=com_babioonevent&task=index&id=456')->
			shouldReturn(
							[
								'option' 	=> 'com_babioonevent',
								'task' 		=> 'index',
								'id' 		=> '456'
							]
		);
	}

}
