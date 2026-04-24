<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\Helpers;

class StringHelper
{
    public static function trim(string $value): string
    {
        return trim($value);
    }
}
