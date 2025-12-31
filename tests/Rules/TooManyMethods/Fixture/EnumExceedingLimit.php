<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods\Fixture;

/**
 * This enum has 26 methods
 * Should fail with default max of 25
 */
enum EnumExceedingLimit: string
{
    case One = 'one';

    public function methodOne(): void {}

    public function methodTwo(): void {}

    public function methodThree(): void {}

    public function methodFour(): void {}

    public function methodFive(): void {}

    public function methodSix(): void {}

    public function methodSeven(): void {}

    public function methodEight(): void {}

    public function methodNine(): void {}

    public function methodTen(): void {}

    public function methodEleven(): void {}

    public function methodTwelve(): void {}

    public function methodThirteen(): void {}

    public function methodFourteen(): void {}

    public function methodFifteen(): void {}

    public function methodSixteen(): void {}

    public function methodSeventeen(): void {}

    public function methodEighteen(): void {}

    public function methodNineteen(): void {}

    public function methodTwenty(): void {}

    public function methodTwentyOne(): void {}

    public function methodTwentyTwo(): void {}

    public function methodTwentyThree(): void {}

    public function methodTwentyFour(): void {}

    public function methodTwentyFive(): void {}

    public function methodTwentySix(): void {}
}
