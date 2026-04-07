<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class VariableVariable
{
    public function dynamic(string $name): mixed
    {
        $foo = 1;
        $bar = 2;
        $baz = 3;

        return $$name;
    }
}
