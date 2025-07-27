<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ConstantNamingConventions\Fixture;

trait ExampleTrait
{
    // Valid constants (all uppercase)
    public const TRAIT_CONSTANT = 'valid';

    public const MAX_RETRIES = 3;

    // Invalid constants (not all uppercase)
    public const traitConstant = 'invalid';

    public const maxRetries = 3;
}
