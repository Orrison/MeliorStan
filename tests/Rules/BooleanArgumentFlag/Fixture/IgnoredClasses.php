<?php

namespace Fixtures\BooleanArgumentFlag;

class IgnoredClass
{
    public function methodWithBool(bool $flag) {}

    public function anotherMethodWithBool(bool $enabled, bool $debug) {}

    public static function staticWithBool(bool $flag) {}
}

class NotIgnoredClass
{
    public function methodWithBool(bool $flag) {}

    public function validMethod(string $name) {}
}

function functionWithBool(bool $flag) {}

$closureWithBool = function (bool $flag) {};
