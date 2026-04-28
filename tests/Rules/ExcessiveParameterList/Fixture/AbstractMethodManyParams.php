<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveParameterList\Fixture;

abstract class AbstractMethodManyParams
{
    abstract public function tooManyParams(int $a, int $b, int $c, int $d): void;
}
