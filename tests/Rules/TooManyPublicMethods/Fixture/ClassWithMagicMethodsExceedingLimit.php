<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods\Fixture;

// 9 plain public methods + __construct + __toString = 11 counted when magic methods are NOT excluded
class ClassWithMagicMethodsExceedingLimit
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
