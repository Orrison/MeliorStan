<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class InheritDocChild extends InheritDocParent
{
    /**
     * @inheritdoc
     */
    public function handle(int $value, string $name): void
    {
        echo $value;
    }
}
