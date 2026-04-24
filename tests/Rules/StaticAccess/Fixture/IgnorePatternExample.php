<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class IgnorePatternExample
{
    public function test(): void
    {
        SomeService::createInstance();
        SomeService::fromArray([]);
        SomeService::make();
        SomeService::process();
        AnotherService::handle();
    }

    public static function createInstance(): static
    {
        return new static();
    }

    public static function fromArray(array $data): static
    {
        return new static();
    }

    public static function make(): static
    {
        return new static();
    }
}
