<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields\Fixture;

// 16 promoted constructor properties, should trigger an error (max is 15)
class ClassWithPromotedProperties
{
    public function __construct(
        public string $fieldOne = '',
        public string $fieldTwo = '',
        public string $fieldThree = '',
        public string $fieldFour = '',
        public string $fieldFive = '',
        public string $fieldSix = '',
        public string $fieldSeven = '',
        public string $fieldEight = '',
        public string $fieldNine = '',
        public string $fieldTen = '',
        public string $fieldEleven = '',
        public string $fieldTwelve = '',
        public string $fieldThirteen = '',
        public string $fieldFourteen = '',
        public string $fieldFifteen = '',
        public string $fieldSixteen = '',
    ) {}
}
