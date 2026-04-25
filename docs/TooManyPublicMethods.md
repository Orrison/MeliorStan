# TooManyPublicMethods

This rule checks if a class, interface, trait, or enum has too many public methods, which may indicate the class has an overly broad public API and should be refactored into smaller, more focused components.

Based on the [PHPMD TooManyPublicMethods](https://phpmd.org/rules/codesize.html#toomanypublicmethods) rule.

## Configuration

This rule supports the following configuration options:

### `max_methods`
- **Type**: `int`
- **Default**: `10`
- **Description**: The maximum number of public methods allowed in a class-like structure before triggering an error.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `^(get|set|is)`
- **Description**: A regular expression pattern (without delimiters) to match public method names that should be excluded from the count. By default, getter, setter, and boolean accessor methods are ignored. Set to an empty string `''` to count all public methods.

### `ignore_magic_methods`
- **Type**: `bool`
- **Default**: `true`
- **Description**: When `true`, PHP magic methods (those starting with `__`, such as `__construct`, `__toString`, `__get`, etc.) are excluded from the public method count. Magic methods are PHP requirements rather than deliberate API choices, so they are ignored by default.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\TooManyPublicMethods\TooManyPublicMethodsRule

parameters:
    meliorstan:
        too_many_public_methods:
            max_methods: 10
            ignore_pattern: '^(get|set|is)'
            ignore_magic_methods: true
```

## Examples

### Default Configuration

```php
<?php

class UserService
{
    public function __construct() {}      // ✓ Ignored (magic method)
    public function getName(): string {}  // ✓ Ignored (matches ignore_pattern)
    public function setName(string $name): void {}  // ✓ Ignored (matches ignore_pattern)
    public function isActive(): bool {}   // ✓ Ignored (matches ignore_pattern)

    // 10 regular public methods — at the limit, no error
    public function register(): void {}
    public function activate(): void {}
    public function deactivate(): void {}
    public function suspend(): void {}
    public function delete(): void {}
    public function restore(): void {}
    public function sendWelcomeEmail(): void {}
    public function sendPasswordReset(): void {}
    public function generateToken(): string {}
    public function revokeToken(): void {}
}
// ✓ Valid — exactly 10 counted methods

class GodService
{
    public function processOrder(): void {}
    public function cancelOrder(): void {}
    public function refundOrder(): void {}
    public function sendInvoice(): void {}
    public function notifyCustomer(): void {}
    public function updateInventory(): void {}
    public function logActivity(): void {}
    public function validatePayment(): void {}
    public function chargeCard(): void {}
    public function applyDiscount(): void {}
    public function calculateTax(): void {}
}
// ✗ Error: Class "GodService" has 11 public methods, which exceeds the maximum of 10. Consider refactoring.
```

### Configuration Examples

#### Count Magic Methods

```neon
parameters:
    meliorstan:
        too_many_public_methods:
            ignore_magic_methods: false
```

```php
<?php

class Service
{
    public function __construct() {}   // Counted
    public function __toString(): string {}  // Counted
    public function methodOne(): void {}
    public function methodTwo(): void {}
    public function methodThree(): void {}
    public function methodFour(): void {}
    public function methodFive(): void {}
    public function methodSix(): void {}
    public function methodSeven(): void {}
    public function methodEight(): void {}
    public function methodNine(): void {}
}
// ✗ Error: Class "Service" has 11 public methods, which exceeds the maximum of 10. Consider refactoring.
```

#### Count All Public Methods (No Ignore Pattern)

```neon
parameters:
    meliorstan:
        too_many_public_methods:
            ignore_pattern: ''
```

```php
<?php

class DataTransferObject
{
    public function getName(): string {}    // Counted (no pattern exclusion)
    public function setName(string $n): void {}  // Counted
    public function getEmail(): string {}   // Counted
    public function setEmail(string $e): void {}  // Counted
    public function getAge(): int {}        // Counted
    public function setAge(int $a): void {} // Counted
    public function isActive(): bool {}     // Counted
    public function isVerified(): bool {}   // Counted
    public function process(): void {}      // Counted
    public function validate(): void {}     // Counted
    public function execute(): void {}      // Counted
}
// ✗ Error: Class "DataTransferObject" has 11 public methods, which exceeds the maximum of 10. Consider refactoring.
```

#### Custom Ignore Pattern

```neon
parameters:
    meliorstan:
        too_many_public_methods:
            ignore_pattern: '^(get|set|is|has|with|can)'
```

```php
<?php

class Builder
{
    public function withTimeout(int $t): self {}    // ✓ Ignored
    public function withRetries(int $r): self {}    // ✓ Ignored
    public function hasItems(): bool {}             // ✓ Ignored
    public function canProcess(): bool {}           // ✓ Ignored
    public function build(): object {}              // Counted
}
```

## Important Notes

- The rule applies to classes, interfaces, traits, and enums
- Interface methods are always counted as public (interfaces are implicitly all-public)
- Static public methods are counted the same as instance public methods
- Protected and private methods are never counted
- The `ignore_pattern` is case-insensitive (e.g., `GetName` and `getname` are both matched)
- Pattern delimiters (`/`) are added automatically — only provide the pattern itself
- Methods are counted based on their declaration in the specific class-like structure, not inherited methods
- Consider using this rule alongside `TooManyMethods` to distinguish between all-method bloat and public API bloat
