<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveParameterList\Fixture;

interface InterfaceManyParams
{
    public function tooManyParams(int $a, int $b, int $c, int $d): void;
}
