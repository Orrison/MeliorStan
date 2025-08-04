# LongClassName

Detects class, interface, trait, and enum names that exceed a configurable maximum length.

This rule helps enforce naming conventions by ensuring that type names remain readable and manageable. It can be configured to subtract specific prefixes and suffixes from the length calculation, allowing for common naming patterns like "Abstract" prefixes or "Interface" suffixes.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `40`
- **Description**: The maximum number of characters allowed for class-like names. Names exceeding this length will trigger a violation.

### `subtract_prefixes`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: A list of prefixes that will be subtracted from the name length calculation. Only the first matching prefix is subtracted.

### `subtract_suffixes`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: A list of suffixes that will be subtracted from the name length calculation. Only the first matching suffix is subtracted.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\LongClassName\LongClassNameRule

parameters:
    messed_up:
        long_class_name:
            maximum: 40
            subtract_prefixes: []
            subtract_suffixes: []
```

## Examples

### Default Configuration

```php
<?php

class User {} // ✓ Valid (4 characters)
class UserRepository {} // ✓ Valid (14 characters)
class VeryLongButStillWithinLimitsClassName {} // ✓ Valid (37 characters)

class ThisIsAnExtremelyLongClassNameThatExceedsTheDefaultMaximumLength {} // ✗ Error: exceeds 40 characters (64 characters)

interface UserRepositoryInterface {} // ✓ Valid (21 characters)
trait AuthenticationTrait {} // ✓ Valid (18 characters)
enum UserStatus {} // ✓ Valid (10 characters)
```

### Maximum Length Configuration

```neon
parameters:
    messed_up:
        long_class_name:
            maximum: 20
```

```php
class VeryLongClassNameThatExceeds {} // ✗ Error: exceeds 20 characters (28 characters)
class ShortName {} // ✓ Valid (9 characters)
```

### Subtract Prefixes Configuration

```neon
parameters:
    messed_up:
        long_class_name:
            maximum: 20
            subtract_prefixes: ["Abstract", "Test"]
```

```php
class AbstractVeryLongClassName {} // ✓ Now valid (effective length: 17, "Abstract" subtracted)
class TestVeryLongClass {} // ✓ Now valid (effective length: 13, "Test" subtracted)
```

### Subtract Suffixes Configuration

```neon
parameters:
    messed_up:
        long_class_name:
            maximum: 20
            subtract_suffixes: ["Interface", "Impl"]
```

```php
class VeryLongClassInterface {} // ✓ Now valid (effective length: 14, "Interface" subtracted)
class VeryLongClassImpl {} // ✓ Now valid (effective length: 12, "Impl" subtracted)
```

### Combined Prefixes and Suffixes

```neon
parameters:
    messed_up:
        long_class_name:
            maximum: 20
            subtract_prefixes: ["Abstract"]
            subtract_suffixes: ["Interface"]
```

```php
class AbstractVeryLongClassInterface {} // ✓ Now valid (effective length: 20, only "Abstract" prefix subtracted)
```

## Important Notes

- Only the first matching prefix and first matching suffix are subtracted from the length calculation
- The rule applies to classes, interfaces, traits, and enums
- Anonymous classes are ignored
- Empty prefixes or suffixes in the configuration arrays are ignored