<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class SomeService
{
    public static string $value = 'test';

    public static function process(): void {}
}
