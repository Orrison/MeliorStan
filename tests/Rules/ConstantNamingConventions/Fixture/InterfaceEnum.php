<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstantNamingConventions\Fixture;

interface ExampleInterface
{
    public const INTERFACE_CONSTANT = 'valid';

    public const interfaceConstant = 'invalid';
}

enum ExampleEnum
{
    public const ENUM_CONSTANT = 'valid';

    public const enumConstant = 'invalid';
    case ValidCase;
    case invalid_case;
}
