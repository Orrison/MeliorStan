<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 50 getter methods, all ignored by the default ignore_pattern '^(get|set|is)'.
 * With the default config, this DTO should pass.
 * When ignore_pattern is set to '', every getter is counted and the class errors.
 */
class DtoWithManyGetters
{
    public function getOne(): int
    {
        return 1;
    }

    public function getTwo(): int
    {
        return 2;
    }

    public function getThree(): int
    {
        return 3;
    }

    public function getFour(): int
    {
        return 4;
    }

    public function getFive(): int
    {
        return 5;
    }

    public function getSix(): int
    {
        return 6;
    }

    public function getSeven(): int
    {
        return 7;
    }

    public function getEight(): int
    {
        return 8;
    }

    public function getNine(): int
    {
        return 9;
    }

    public function getTen(): int
    {
        return 10;
    }

    public function getEleven(): int
    {
        return 11;
    }

    public function getTwelve(): int
    {
        return 12;
    }

    public function getThirteen(): int
    {
        return 13;
    }

    public function getFourteen(): int
    {
        return 14;
    }

    public function getFifteen(): int
    {
        return 15;
    }

    public function getSixteen(): int
    {
        return 16;
    }

    public function getSeventeen(): int
    {
        return 17;
    }

    public function getEighteen(): int
    {
        return 18;
    }

    public function getNineteen(): int
    {
        return 19;
    }

    public function getTwenty(): int
    {
        return 20;
    }

    public function getTwentyOne(): int
    {
        return 21;
    }

    public function getTwentyTwo(): int
    {
        return 22;
    }

    public function getTwentyThree(): int
    {
        return 23;
    }

    public function getTwentyFour(): int
    {
        return 24;
    }

    public function getTwentyFive(): int
    {
        return 25;
    }

    public function getTwentySix(): int
    {
        return 26;
    }

    public function getTwentySeven(): int
    {
        return 27;
    }

    public function getTwentyEight(): int
    {
        return 28;
    }

    public function getTwentyNine(): int
    {
        return 29;
    }

    public function getThirty(): int
    {
        return 30;
    }

    public function getThirtyOne(): int
    {
        return 31;
    }

    public function getThirtyTwo(): int
    {
        return 32;
    }

    public function getThirtyThree(): int
    {
        return 33;
    }

    public function getThirtyFour(): int
    {
        return 34;
    }

    public function getThirtyFive(): int
    {
        return 35;
    }

    public function getThirtySix(): int
    {
        return 36;
    }

    public function getThirtySeven(): int
    {
        return 37;
    }

    public function getThirtyEight(): int
    {
        return 38;
    }

    public function getThirtyNine(): int
    {
        return 39;
    }

    public function getForty(): int
    {
        return 40;
    }

    public function getFortyOne(): int
    {
        return 41;
    }

    public function getFortyTwo(): int
    {
        return 42;
    }

    public function getFortyThree(): int
    {
        return 43;
    }

    public function getFortyFour(): int
    {
        return 44;
    }

    public function getFortyFive(): int
    {
        return 45;
    }

    public function getFortySix(): int
    {
        return 46;
    }

    public function getFortySeven(): int
    {
        return 47;
    }

    public function getFortyEight(): int
    {
        return 48;
    }

    public function getFortyNine(): int
    {
        return 49;
    }

    public function getFifty(): int
    {
        return 50;
    }
}
