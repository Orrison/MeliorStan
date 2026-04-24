<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class PropertyIgnorePatternExample
{
    public function test(): void
    {
        SomeService::process();
        SomeService::$value;
        AnotherService::$count;
        AnotherService::$configValue;
        AnotherService::$defaultTimeout;
    }
}
