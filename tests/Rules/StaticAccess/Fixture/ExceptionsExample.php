<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class ExceptionsExample
{
    public function test(): void
    {
        AllowedService::allowed();
        SomeService::process();
        AnotherService::handle();
    }
}
