<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class InheritDocParent
{
    public function handle(int $value, string $name): void
    {
        echo $value . $name;
    }
}
