<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 6 public methods and 3 cases. Cases must NOT be counted toward the public
 * member total, only the methods count, so this exceeds maximum 5.
 */
enum SmallEnumExceedingLimit
{
    case FIRST;
    case SECOND;
    case THIRD;

    public function enumOne(): void {}

    public function enumTwo(): void {}

    public function enumThree(): void {}

    public function enumFour(): void {}

    public function enumFive(): void {}

    public function enumSix(): void {}
}
