<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class VariableVariable
{
    public function dynamic(string $name, int $value): void
    {
        $$name = $value;
        echo $$name;
    }
}
