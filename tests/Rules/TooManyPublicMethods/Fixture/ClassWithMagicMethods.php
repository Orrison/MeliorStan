<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods\Fixture;

// 9 plain public methods + __construct + __toString, magic methods excluded, so no error (9 <= 10)
class ClassWithMagicMethods
{
    public function __construct() {}

    public function __toString(): string
    {
        return '';
    }

    public function methodOne(): void {}

    public function methodTwo(): void {}

    public function methodThree(): void {}

    public function methodFour(): void {}

    public function methodFive(): void {}

    public function methodSix(): void {}

    public function methodSeven(): void {}

    public function methodEight(): void {}

    public function methodNine(): void {}
}
