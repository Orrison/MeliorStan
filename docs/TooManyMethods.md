# TooManyMethods

This rule checks if a class, interface, trait, or enum has too many methods, which may indicate the class is doing too much and should be refactored.

Based on the [PHPMD TooManyMethods](https://phpmd.org/rules/codesize.html#toomanymethods) rule.

## Configuration

This rule supports the following configuration options:

### `max_methods`
- **Type**: `int`
- **Default**: `25`
- **Description**: The maximum number of methods allowed in a class-like structure before triggering an error.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `^(get|set|is)`
- **Description**: A regular expression pattern (without delimiters) to match method names that should be excluded from the count. By default, getter, setter, and boolean accessor methods are ignored. Set to an empty string `''` to count all methods.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\TooManyMethods\TooManyMethodsRule

parameters:
    meliorstan:
        too_many_methods:
            max_methods: 25
            ignore_pattern: '^(get|set|is)'
```

## Examples

### Default Configuration

```php
<?php

class UserService
{
    // 10 getters - ignored by default
    public function getName(): string { return ''; }
    public function getEmail(): string { return ''; }
    // ... more getters

    // 5 setters - ignored by default
    public function setName(string $name): void {}
    // ... more setters

    // 5 is* methods - ignored by default
    public function isActive(): bool { return true; }
    // ... more is* methods

    // 10 regular methods - these are counted
    public function process(): void {}
    public function validate(): void {}
    // ... more methods
}
// ✓ Valid - only 10 methods counted (getters/setters/is* ignored)

class GodClass
{
    public function methodOne(): void {}
    public function methodTwo(): void {}
    // ... 26 total methods without get/set/is prefix
}
// ✗ Error: Class "GodClass" has 26 methods, which exceeds the maximum of 25. Consider refactoring.
```

### Configuration Examples

#### Custom Maximum

```neon
parameters:
    meliorstan:
        too_many_methods:
            max_methods: 10
```

```php
<?php

class Service
{
    public function methodOne(): void {}
    public function methodTwo(): void {}
    // ... 11 total methods
}
// ✗ Error: Class "Service" has 11 methods, which exceeds the maximum of 10.
```

#### Count All Methods (No Ignore Pattern)

```neon
parameters:
    meliorstan:
        too_many_methods:
            ignore_pattern: ''
```

```php
<?php

class DataTransferObject
{
    public function getName(): string { return ''; }
    public function setName(string $name): void {}
    public function getEmail(): string { return ''; }
    public function setEmail(string $email): void {}
    // ... 30 total methods including getters/setters
}
// ✗ Error: Class "DataTransferObject" has 30 methods, which exceeds the maximum of 25.
```

#### Custom Ignore Pattern

```neon
parameters:
    meliorstan:
        too_many_methods:
            ignore_pattern: '^(get|set|is|has|with)'
```

```php
<?php

class Builder
{
    public function getName(): string { return ''; }     // ✓ Ignored
    public function setName(string $n): void {}          // ✓ Ignored
    public function isValid(): bool { return true; }     // ✓ Ignored
    public function hasItems(): bool { return true; }    // ✓ Ignored
    public function withTimeout(int $t): self {}         // ✓ Ignored
    public function build(): object { return new \stdClass(); }  // Counted
}
```

## Important Notes

- The rule applies to classes, interfaces, traits, and enums
- The `ignore_pattern` is case-insensitive (e.g., `getName` and `GETNAME` are both matched)
- Pattern delimiters (`/`) are added automatically - only provide the pattern itself
- Methods are counted based on their declaration in the specific class-like structure, not inherited methods
- Consider using this rule to identify classes that may benefit from being split into smaller, more focused classes (Single Responsibility Principle)
