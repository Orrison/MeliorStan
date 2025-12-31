<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture;

class DefaultExample
{
    public function __construct(bool $debug) {}

    public function processWithFlag(bool $flag) {}

    public function handleNullable(?bool $option) {}

    public function unionType(bool|null $value) {}

    public function multiUnion(int|bool $mixed) {}

    public function validMethod(string $name, int $count) {}

    public static function staticMethod(bool $enabled) {}

    public function __set(string $name, bool $value) {}

    public function multipleParams(string $name, bool $enabled, int $count) {}

    public function multipleBools(bool $first, bool $second) {}

    protected function protectedMethod(bool $flag) {}

    private function privateMethod(bool $flag) {}
}

function namedFunction(bool $flag) {}

function validNamedFunction(string $name) {}

$closure = function (bool $flag) {};

$validClosure = function (string $name) {};

$arrow = fn (bool $flag) => $flag;

$validArrow = fn (string $name) => $name;

$closureMultipleParams = function (string $name, bool $enabled) {};

$nestedClosure = function (bool $outer) {
    return function (bool $inner) {
        return $inner;
    };
};
