<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 6 public methods in a trait, exceeds a custom maximum of 5.
 */
trait SmallTraitExceedingLimit
{
    public function traitOne(): void {}

    public function traitTwo(): void {}

    public function traitThree(): void {}

    public function traitFour(): void {}

    public function traitFive(): void {}

    public function traitSix(): void {}
}
