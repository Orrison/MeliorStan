<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\TraitConstantNamingConventions\Fixture;

trait ExampleTrait
{
    // Valid constants (all uppercase)
    public const TRAIT_CONSTANT = 'valid';

    public const MAX_RETRIES = 3;

    public const ANOTHER_VALID_CONSTANT = 'test';

    // Invalid constants (not all uppercase)
    public const traitConstant = 'invalid';

    public const maxRetries = 3;

    public const mixedCase = 'invalid';
}
