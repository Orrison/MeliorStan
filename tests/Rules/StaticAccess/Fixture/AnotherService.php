<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class AnotherService
{
    public static int $count = 0;

    public static string $configValue = 'test';

    public static int $defaultTimeout = 30;

    public static function handle(): void {}
}
