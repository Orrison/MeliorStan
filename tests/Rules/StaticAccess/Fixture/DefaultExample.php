<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

class DefaultExample extends BaseExample
{
    public static function helper(): void {}

    public function test(): void
    {
        SomeService::process();
        AnotherService::handle();
        self::helper();
        static::helper();
        parent::baseMethod();
    }
}
