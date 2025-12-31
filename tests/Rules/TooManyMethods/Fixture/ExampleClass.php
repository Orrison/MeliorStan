<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods\Fixture;

/**
 * This class has 30 total methods:
 * - 10 getters - ignored by default pattern
 * - 5 setters - ignored by default pattern
 * - 5 is* methods - ignored by default pattern
 * - 10 other methods - counted
 *
 * With default ignore pattern ^(get|set|is): 10 methods counted (passes)
 * Without ignore pattern: 30 methods counted (fails with default max 25)
 */
class ClassWithManyMethods
{
    public function getName(): string
    {
        return '';
    }

    public function getAge(): int
    {
        return 0;
    }

    public function getEmail(): string
    {
        return '';
    }

    public function getPhone(): string
    {
        return '';
    }

    public function getAddress(): string
    {
        return '';
    }

    public function getCity(): string
    {
        return '';
    }

    public function getCountry(): string
    {
        return '';
    }

    public function getZipCode(): string
    {
        return '';
    }

    public function getState(): string
    {
        return '';
    }

    public function getFullName(): string
    {
        return '';
    }

    public function setName(string $name): void {}

    public function setAge(int $age): void {}

    public function setEmail(string $email): void {}

    public function setPhone(string $phone): void {}

    public function setAddress(string $address): void {}

    public function isActive(): bool
    {
        return true;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function isEnabled(): bool
    {
        return true;
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isDeleted(): bool
    {
        return false;
    }

    public function doSomething(): void {}

    public function process(): void {}

    public function handle(): void {}

    public function execute(): void {}

    public function run(): void {}

    public function validate(): void {}

    public function transform(): void {}

    public function convert(): void {}

    public function parse(): void {}

    public function format(): void {}
}

/**
 * This class has 26 regular methods (no getters/setters/is*)
 * Should fail with default max of 25
 */
class ClassExceedingLimit
{
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

/**
 * This trait has 26 regular methods
 * Should fail with default max of 25
 */
trait TraitExceedingLimit
{
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

/**
 * This interface has 26 method signatures
 * Should fail with default max of 25
 */
interface InterfaceExceedingLimit
{
    public function methodOne(): void;

    public function methodTwo(): void;

    public function methodThree(): void;

    public function methodFour(): void;

    public function methodFive(): void;

    public function methodSix(): void;

    public function methodSeven(): void;

    public function methodEight(): void;

    public function methodNine(): void;

    public function methodTen(): void;

    public function methodEleven(): void;

    public function methodTwelve(): void;

    public function methodThirteen(): void;

    public function methodFourteen(): void;

    public function methodFifteen(): void;

    public function methodSixteen(): void;

    public function methodSeventeen(): void;

    public function methodEighteen(): void;

    public function methodNineteen(): void;

    public function methodTwenty(): void;

    public function methodTwentyOne(): void;

    public function methodTwentyTwo(): void;

    public function methodTwentyThree(): void;

    public function methodTwentyFour(): void;

    public function methodTwentyFive(): void;

    public function methodTwentySix(): void;
}

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
