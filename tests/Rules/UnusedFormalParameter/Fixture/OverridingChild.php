<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class OverridingChild extends OverridingParent
{
    public function process(int $value, string $name): void
    {
        echo $value;
    }
}
