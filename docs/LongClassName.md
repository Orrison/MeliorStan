# LongClassName

This rule checks if a class, interface, trait, or enum name exceeds the configured maximum length, excluding certain configured prefixes and suffixes.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `40`
- **Description**: The maximum allowed length for class/interface/trait/enum names.

### `subtract_prefixes`
- **Type**: `string[]`
- **Default**: `[]`
- **Description**: An array of prefixes to exclude from the length calculation.

### `subtract_suffixes`
- **Type**: `string[]`
- **Default**: `[]`
- **Description**: An array of suffixes to exclude from the length calculation.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\LongClassName\LongClassNameRule

parameters:
    meliorstan:
        long_class_name:
            maximum: 40
            subtract_prefixes: []
            subtract_suffixes: []
```

## Examples

### Default Configuration

```php
<?php

class VeryLongClassNameThatExceedsTheDefaultMaximumLength {} // ✗ Error: Class name "VeryLongClassNameThatExceedsTheDefaultMaximumLength" is too long (55 chars). Maximum allowed length is 40 characters.

class ShortClass {} // ✓ Valid
```

### Custom Maximum

```neon
parameters:
    meliorstan:
        long_class_name:
            maximum: 60
```

```php
<?php

class VeryLongClassNameThatExceedsTheDefaultMaximumLength {} // ✓ Now valid with custom maximum
```

### Subtract Prefixes

```neon
parameters:
    meliorstan:
        long_class_name:
            subtract_prefixes: ["VeryLong"]
```

```php
<?php

class VeryLongClassName {} // ✓ Valid (18 chars - 8 chars for "VeryLong" = 10 chars, within limit)
```

### Subtract Suffixes

```neon
parameters:
    meliorstan:
        long_class_name:
            subtract_suffixes: ["Class"]
```

```php
<?php

class VeryLongClassNameClass {} // ✓ Valid (22 chars - 5 chars for "Class" = 17 chars, within limit)
```

## Important Notes

- Only one prefix and one suffix can be subtracted from each class name (following PHPMD behavior)
- Suffixes are checked and removed before prefixes
- The rule applies to classes, interfaces, traits, and enums