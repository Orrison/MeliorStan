<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods\Fixture;

// 11 methods (interfaces are implicitly all-public) — should trigger an error
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
}
