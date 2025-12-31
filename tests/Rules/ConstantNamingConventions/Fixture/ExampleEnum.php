<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstantNamingConventions\Fixture;

enum ExampleEnum
{
    public const ENUM_CONSTANT = 'valid';

    public const enumConstant = 'invalid';
    case ValidCase;
    case invalid_case;
}
