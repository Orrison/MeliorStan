<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 6 interface methods (implicitly public), exceeds a custom maximum of 5.
 */
interface SmallInterfaceExceedingLimit
{
    public function one(): void;

    public function two(): void;

    public function three(): void;

    public function four(): void;

    public function five(): void;

    public function six(): void;
}
