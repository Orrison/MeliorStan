<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 20 public methods (non-ignored names) + 25 public properties = 45 public members.
 * Exactly at the default maximum of 45 — should not trigger an error.
 */
class ClassAtLimit
{
    public int $propertyOne = 0;

    public int $propertyTwo = 0;

    public int $propertyThree = 0;

    public int $propertyFour = 0;

    public int $propertyFive = 0;

    public int $propertySix = 0;

    public int $propertySeven = 0;

    public int $propertyEight = 0;

    public int $propertyNine = 0;

    public int $propertyTen = 0;

    public int $propertyEleven = 0;

    public int $propertyTwelve = 0;

    public int $propertyThirteen = 0;

    public int $propertyFourteen = 0;

    public int $propertyFifteen = 0;

    public int $propertySixteen = 0;

    public int $propertySeventeen = 0;

    public int $propertyEighteen = 0;

    public int $propertyNineteen = 0;

    public int $propertyTwenty = 0;

    public int $propertyTwentyOne = 0;

    public int $propertyTwentyTwo = 0;

    public int $propertyTwentyThree = 0;

    public int $propertyTwentyFour = 0;

    public int $propertyTwentyFive = 0;

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
}
