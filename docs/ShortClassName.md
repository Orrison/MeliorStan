# ShortClassName

Ensures that class names meet a minimum character length requirement.

This rule validates that all class names are not too short, helping to enforce meaningful and descriptive naming. This applies to classes, interfaces, traits, and enums, ensuring they have sufficient length to be descriptive and meaningful.

## Configuration

This rule supports the following configuration options:

### `minimum`
- **Type**: `int`
- **Default**: `3`
- **Description**: Sets the minimum allowed length for class names. Class names shorter than this will trigger a violation.

### `exceptions`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: An array of class names that are allowed even if they don't meet the minimum length requirement. Useful for common abbreviations or single-letter class names that are widely recognized.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ShortClassName\ShortClassNameRule

parameters:
    meliorstan:
        short_class_name:
            minimum: 3
            exceptions: []
```

## Examples

### Default Configuration

```php
<?php

// Valid class names
class UserController {} // ✓ Valid (13 chars)
class Car {} // ✓ Valid (3 chars - meets minimum)
class DatabaseConnection {} // ✓ Valid (18 chars)
interface PaymentProcessor {} // ✓ Valid (16 chars)

// Invalid class names
class A {} // ✗ Error: Class name "A" is too short (1 chars). Minimum allowed length is 3 characters.
class AB {} // ✗ Error: Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.
interface I {} // ✗ Error: Interface name "I" is too short (1 chars). Minimum allowed length is 3 characters.
trait T {} // ✗ Error: Trait name "T" is too short (1 chars). Minimum allowed length is 3 characters.
enum E {} // ✗ Error: Enum name "E" is too short (1 chars). Minimum allowed length is 3 characters.
```

### Configuration Examples

#### Custom Minimum Length

```neon
parameters:
    meliorstan:
        short_class_name:
            minimum: 5
```

```php
class User {} // ✗ Error: Class name "User" is too short (4 chars). Minimum allowed length is 5 characters.
class Admin {} // ✓ Now valid (5 chars)
```

#### Exceptions

```neon
parameters:
    meliorstan:
        short_class_name:
            exceptions: ["A", "B", "I"]
```

```php
class A {} // ✓ Now valid (exception)
class B {} // ✓ Now valid (exception)
class C {} // ✗ Error: Class name "C" is too short (1 chars). Minimum allowed length is 3 characters.
interface I {} // ✓ Now valid (exception)
```

## Important Notes

- This rule applies to all class-like structures: classes, interfaces, traits, and enums
- Anonymous classes are not validated by this rule
- The rule only validates the class name itself, not namespaces or fully qualified names
- Exceptions are matched exactly by class name - they are case-sensitive
- When using exceptions, consider the trade-off between brevity and clarity in your codebase