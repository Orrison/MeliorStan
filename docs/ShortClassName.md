# ShortClassName

This rule checks if a class, interface, trait, or enum name is shorter than the configured minimum length, with optional exceptions for specific names.

## Configuration

This rule supports the following configuration options:

### `minimum`
- **Type**: `int`
- **Default**: `3`
- **Description**: The minimum allowed length for class/interface/trait/enum names.

### `exceptions`
- **Type**: `string[]`
- **Default**: `[]`
- **Description**: An array of class/interface/trait/enum names that are allowed even if they do not meet the minimum length requirement.

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

class A {} // ✗ Error: Class name "A" is too short (1 chars). Minimum allowed length is 3 characters.
class AB {} // ✗ Error: Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.
class ABC {} // ✓ Valid
```

### Custom Minimum

```neon
parameters:
    meliorstan:
        short_class_name:
            minimum: 2
```

```php
<?php

class A {} // ✗ Error: Class name "A" is too short (1 chars). Minimum allowed length is 2 characters.
class AB {} // ✓ Now valid
class ABC {} // ✓ Valid
```

### Exceptions

```neon
parameters:
    meliorstan:
        short_class_name:
            exceptions: ["A"]
```

```php
<?php

class A {} // ✓ Now valid (exception)
class AB {} // ✗ Error: Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.
class ABC {} // ✓ Valid
```

## Important Notes

This rule applies to all class-like constructs including classes, interfaces, traits, and enums.