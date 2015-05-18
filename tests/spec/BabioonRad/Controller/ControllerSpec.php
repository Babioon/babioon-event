<?php

namespace spec\BabioonRad\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BabioonRad\Controller\Controller');
    }
}
