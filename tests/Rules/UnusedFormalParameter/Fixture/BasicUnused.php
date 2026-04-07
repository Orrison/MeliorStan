<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class BasicUnused
{
    public function doSomething(int $used, int $unused): int
    {
        return $used + 1;
    }
}

function basic_unused_function(int $used, int $unused): int
{
    return $used + 1;
}
