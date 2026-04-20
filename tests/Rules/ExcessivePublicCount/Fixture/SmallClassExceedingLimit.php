<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 6 public methods with non-ignored names. Exceeds a custom maximum of 5.
 */
class SmallClassExceedingLimit
{
    public function doOne(): void {}

    public function doTwo(): void {}

    public function doThree(): void {}

    public function doFour(): void {}

    public function doFive(): void {}

    public function doSix(): void {}
}
