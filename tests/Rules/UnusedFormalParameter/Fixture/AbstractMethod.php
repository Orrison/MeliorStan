<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

abstract class AbstractMethod
{
    abstract public function doSomething(int $value, string $name): void;
}
