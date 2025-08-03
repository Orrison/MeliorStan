# BooleanGetMethodName

Enforces that methods with boolean return types should not start with "get".

This rule detects methods that start with "get" (or "_get") and return a boolean value, suggesting the use of more descriptive naming conventions like "is" or "has" for boolean getters.

## Configuration

This rule supports the following configuration options:

### `check_parameterized_methods`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When `true`, the rule also applies to methods that have parameters. When `false` (default), only methods with no parameters are checked.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\BooleanGetMethodName\BooleanGetMethodNameRule

parameters:
    messed_up:
        boolean_get_method_name:
            check_parameterized_methods: false
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    // Valid boolean methods
    public function isActive(): bool {} // ✓ Valid
    public function hasItems(): bool {} // ✓ Valid
    public function canPerform(): bool {} // ✓ Valid
    
    // Valid get methods (non-boolean return)
    public function getName(): string {} // ✓ Valid
    public function getCount(): int {} // ✓ Valid
    
    // Invalid - get methods with boolean return
    public function getEnabled(): bool {} // ✗ Error: Method "getEnabled" starts with "get" and returns boolean, consider using "is" or "has" instead.
    public function getValid(): bool {} // ✗ Error: Method "getValid" starts with "get" and returns boolean, consider using "is" or "has" instead.
    
    /**
     * @return bool
     */
    public function getFlag() {} // ✗ Error: Method "getFlag" starts with "get" and returns boolean, consider using "is" or "has" instead.
    
    // Methods with parameters are ignored by default
    public function getIsActive(string $type): bool {} // ✓ Valid (has parameters)
}
```

### Configuration Examples

#### Check Parameterized Methods

```neon
parameters:
    messed_up:
        boolean_get_method_name:
            check_parameterized_methods: true
```

```php
public function getActiveFlag(string $type): bool {} // ✗ Now invalid
public function getValidated(array $data): bool {} // ✗ Now invalid
```

## Important Notes

- This rule applies to methods that start with "get" or "_get" (case-insensitive)
- Boolean return types include: `bool`, `true`, `false` (both in type declarations and `@return` annotations)
- By default, only methods with no parameters are checked
- When `check_parameterized_methods` is enabled, methods with parameters are also validated
- Consider using "is", "has", "can", "should", or "will" prefixes for boolean getters instead of "get"
