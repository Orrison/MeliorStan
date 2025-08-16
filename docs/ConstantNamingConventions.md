# ConstantNamingConventions

Enforces that constant names should be in UPPERCASE.

This rule validates that all class constant names follow the uppercase naming convention, where all letters are uppercase and words are separated by underscores. This applies to constants in classes, interfaces, and enums.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ConstantNamingConventions\ConstantNamingConventionsRule
```

## Examples

```php
<?php

class Example
{
    // Valid constant names
    public const MAX_CONNECTIONS = 100; // ✓ Valid uppercase
    public const DEFAULT_TIMEOUT = 30; // ✓ Valid uppercase  
    public const API_VERSION = '1.0'; // ✓ Valid uppercase
    private const INTERNAL_FLAG = true; // ✓ Valid uppercase
    protected const BUFFER_SIZE = 1024; // ✓ Valid uppercase
    
    // Invalid constant names
    public const maxConnections = 100; // ✗ Error: Constant name "maxConnections" is not in UPPERCASE.
    public const Default_Timeout = 30; // ✗ Error: Constant name "Default_Timeout" is not in UPPERCASE.
    public const api_version = '1.0'; // ✗ Error: Constant name "api_version" is not in UPPERCASE.
    public const InternalFlag = true; // ✗ Error: Constant name "InternalFlag" is not in UPPERCASE.
    public const bufferSize = 1024; // ✗ Error: Constant name "bufferSize" is not in UPPERCASE.
}

interface ApiInterface
{
    public const API_VERSION = '2.0'; // ✓ Valid uppercase
    public const apiVersion = '2.0'; // ✗ Error: Constant name "apiVersion" is not in UPPERCASE.
}

enum Status
{
    case ACTIVE;
    case INACTIVE;
    
    public const DEFAULT_STATUS = self::ACTIVE; // ✓ Valid uppercase
    public const defaultStatus = self::ACTIVE; // ✗ Error: Constant name "defaultStatus" is not in UPPERCASE.
}
```

## Important Notes

- This rule applies to constants in classes, interfaces, and enums
- For trait constants, use the TraitConstantNamingConventions rule instead
- Constants are checked regardless of their visibility (public, protected, private)
- The rule enforces the traditional PHP constant naming convention where all letters must be uppercase
- Underscores are allowed and encouraged for separating words in constant names
- This rule only validates class/interface/enum constants, not global constants defined with `define()`
- Enum cases are not validated by this rule, only enum constants
