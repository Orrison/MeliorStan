<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveParameterList\Fixture;

class IgnoredMethodByPattern
{
    public function ignoredMethod(int $a, int $b, int $c, int $d): void {}
}
