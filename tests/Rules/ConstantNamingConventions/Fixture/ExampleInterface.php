<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstantNamingConventions\Fixture;

interface ExampleInterface
{
    public const INTERFACE_CONSTANT = 'valid';

    public const interfaceConstant = 'invalid';
}
