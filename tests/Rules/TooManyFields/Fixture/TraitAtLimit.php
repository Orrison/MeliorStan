<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields\Fixture;

// Exactly 15 instance fields in a trait — should not trigger an error
trait TraitAtLimit
{
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

    public string $fieldFifteen = '';
}
