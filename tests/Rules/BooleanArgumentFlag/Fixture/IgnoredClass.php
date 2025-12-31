<?php

namespace Fixtures\BooleanArgumentFlag;

class IgnoredClass
{
    public function methodWithBool(bool $flag) {}

    public function anotherMethodWithBool(bool $enabled, bool $debug) {}

    public static function staticWithBool(bool $flag) {}
}
