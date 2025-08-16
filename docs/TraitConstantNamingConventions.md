# TraitConstantNamingConventions

Enforces that all trait constants use UPPERCASE naming convention.

This rule validates that all constants declared within traits follow the UPPERCASE naming convention, which is the standard PHP naming convention for constants. This rule is specifically designed for trait constants and works alongside the ConstantNamingConventions rule which handles class, interface, and enum constants.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/mess-stan/config/extension.neon

rules:
    - Orrison\MessStan\Rules\TraitConstantNamingConventions\TraitConstantNamingConventionsRule
```

## Examples

### Default Configuration

```php
<?php

trait ExampleTrait
{
    // ✓ Valid - All uppercase
    public const TRAIT_CONSTANT = 'valid';
    public const MAX_RETRIES = 3;
    public const ANOTHER_VALID_CONSTANT = 'test';
    
    // ✗ Error: Constant name "traitConstant" is not in UPPERCASE.
    public const traitConstant = 'invalid';
    
    // ✗ Error: Constant name "maxRetries" is not in UPPERCASE.
    public const maxRetries = 3;
    
    // ✗ Error: Constant name "mixedCase" is not in UPPERCASE.
    public const mixedCase = 'invalid';
}
```

## Important Notes

This rule only applies to trait constants. For class, interface, and enum constants, use the ConstantNamingConventions rule instead.
