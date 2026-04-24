<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class StaticPropertyAccessExample
{
    protected static string $ownProperty = 'test';

    public function test(): void
    {
        SomeService::process();
        SomeService::$value;
        AnotherService::$count;
        self::$ownProperty;
        static::$ownProperty;
    }
}
