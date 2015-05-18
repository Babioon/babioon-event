<?php

namespace spec\BabioonEvent\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BabioonEvent\Event\Event');
    }
}
