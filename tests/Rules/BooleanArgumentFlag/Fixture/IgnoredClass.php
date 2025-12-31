<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture;

class IgnoredClass
{
    public function methodWithBool(bool $flag) {}

    public function anotherMethodWithBool(bool $enabled, bool $debug) {}

    public static function staticWithBool(bool $flag) {}
}
