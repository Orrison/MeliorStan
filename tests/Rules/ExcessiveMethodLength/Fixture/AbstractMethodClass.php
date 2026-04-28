<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength\Fixture;

abstract class AbstractMethodClass
{
    abstract public function abstractMethod(): void;

    abstract public function anotherAbstractMethod(string $value): int;
}
