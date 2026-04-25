# TooManyFields

This rule checks if a class or trait has too many instance fields (properties), which may indicate the class has taken on too many responsibilities and should be refactored into smaller, more focused components.

## Configuration

This rule supports the following configuration options:

### `max_fields`
- **Type**: `int`
- **Default**: `15`
- **Description**: The maximum number of fields allowed in a class or trait before triggering an error.

### `ignore_static_properties`
- **Type**: `bool`
- **Default**: `true`
- **Description**: When `true`, static properties are excluded from the field count. Static properties are typically shared state or registries rather than per-instance data, so they are ignored by default.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\TooManyFields\TooManyFieldsRule

parameters:
    meliorstan:
        too_many_fields:
            max_fields: 15
            ignore_static_properties: true
```

## Examples

### Default Configuration

```php
<?php

class UserProfile
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $phone = '';
    public string $addressLine1 = '';
    public string $addressLine2 = '';
    public string $city = '';
    public string $state = '';
    public string $postalCode = '';
    public string $country = '';
    public string $avatarUrl = '';
    public string $bio = '';
    public bool $isActive = true;
    public bool $isVerified = false;
    public string $timezone = '';
}
// ✓ Valid — exactly 15 fields

class GodObject
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $phone = '';
    public string $addressLine1 = '';
    public string $addressLine2 = '';
    public string $city = '';
    public string $state = '';
    public string $postalCode = '';
    public string $country = '';
    public string $avatarUrl = '';
    public string $bio = '';
    public bool $isActive = true;
    public bool $isVerified = false;
    public string $timezone = '';
    public string $preferredLanguage = '';
}
// ✗ Error: Class "GodObject" has 16 fields, which exceeds the maximum of 15. Consider refactoring.
```

### Configuration Examples

#### Count Static Properties

```neon
parameters:
    meliorstan:
        too_many_fields:
            ignore_static_properties: false
```

```php
<?php

class Registry
{
    public static string $connection = '';   // Counted
    public static int $instanceCount = 0;   // Counted
    public static bool $booted = false;     // Counted

    public string $fieldOne = '';
    // ... 12 more instance fields
}
// ✗ Error: Class "Registry" has 16 fields, which exceeds the maximum of 15. Consider refactoring.
```

#### Lower Maximum for Stricter Codebases

```neon
parameters:
    meliorstan:
        too_many_fields:
            max_fields: 10
```

```php
<?php

class ProductData
{
    public string $name = '';
    public string $sku = '';
    public float $price = 0.0;
    public int $stock = 0;
    public string $category = '';
    public string $description = '';
    public string $imageUrl = '';
    public bool $isActive = true;
    public string $brand = '';
    public string $supplier = '';
    public string $barcode = '';   // 11th field
}
// ✗ Error: Class "ProductData" has 11 fields, which exceeds the maximum of 10. Consider refactoring.
```

## Important Notes

- The rule applies to classes and traits; interfaces and enums are always skipped
- Only fields declared directly in the class or trait are counted — inherited fields are not included
- Compound property declarations (`public string $a, $b, $c;`) count as multiple fields (one per variable)
- Constructor-promoted properties are counted like any other instance property
- Consider pairing this rule with [ExcessivePublicCount](ExcessivePublicCount.md) to also limit the total public API surface
