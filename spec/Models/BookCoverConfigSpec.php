<?php

namespace spec\Gutenberg\Models;

use Gutenberg\Models\BookCoverConfig;
use PhpSpec\ObjectBehavior;

class BookCoverConfigSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BookCoverConfig::class);
    }

    public function it_has_different_configurations()
    {
        
    }
}
