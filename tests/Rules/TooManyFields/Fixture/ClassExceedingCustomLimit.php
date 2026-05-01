<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields\Fixture;

// 6 instance fields, exceeds a custom max of 5
class ClassExceedingCustomLimit
{
    public string $fieldOne = '';

    public string $fieldTwo = '';

    public string $fieldThree = '';

    public string $fieldFour = '';

    public string $fieldFive = '';

    public string $fieldSix = '';
}
