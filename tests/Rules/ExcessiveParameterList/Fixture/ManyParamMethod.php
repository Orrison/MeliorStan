<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveParameterList\Fixture;

class ManyParamMethod
{
    public function tooManyParams(int $a, int $b, int $c, int $d): void {}
}
