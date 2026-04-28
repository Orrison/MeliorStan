<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength\Fixture;

interface InterfaceMethods
{
    public function methodOne(): void;

    public function methodTwo(string $value): int;
}
