<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods\Fixture;

/**
 * This class has exactly 5 methods, all regular (no getters/setters/is*)
 * Should pass with default max of 25
 */
class ClassWithFewMethods
{
    public function methodOne(): void {}

    public function methodTwo(): void {}

    public function methodThree(): void {}

    public function methodFour(): void {}

    public function methodFive(): void {}
}
