<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods\Fixture;

/**
 * Class with 6 regular methods - for testing custom max_methods=5
 */
class ClassWithSixMethods
{
    public function methodOne(): void {}

    public function methodTwo(): void {}

    public function methodThree(): void {}

    public function methodFour(): void {}

    public function methodFive(): void {}

    public function methodSix(): void {}
}
