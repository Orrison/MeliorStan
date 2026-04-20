<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 6 getter methods. With the default ignore_pattern they all get skipped.
 * With ignore_pattern='' they are all counted and exceed a custom maximum of 5.
 */
class SmallDtoWithGetters
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
}
