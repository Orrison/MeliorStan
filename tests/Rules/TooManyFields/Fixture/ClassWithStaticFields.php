<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields\Fixture;

// 14 instance fields + 3 static fields = 17 total
// With ignore_static_properties: true (default) → 14 counted → no error
// With ignore_static_properties: false → 17 counted → error
class ClassWithStaticFields
{
    public static string $registry = '';

    public static int $instanceCount = 0;

    public static bool $booted = false;

    public string $fieldOne = '';

    public string $fieldTwo = '';

    public string $fieldThree = '';

    public string $fieldFour = '';

    public string $fieldFive = '';

    public string $fieldSix = '';

    public string $fieldSeven = '';

    public string $fieldEight = '';

    public string $fieldNine = '';

    public string $fieldTen = '';

    public string $fieldEleven = '';

    public string $fieldTwelve = '';

    public string $fieldThirteen = '';

    public string $fieldFourteen = '';
}
