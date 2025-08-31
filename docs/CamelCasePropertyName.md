# CamelCasePropertyName

Enforces that class property names should follow camelCase naming convention.

This rule validates that all property names in classes follow the camelCase pattern, where the first letter is lowercase and subsequent words start with uppercase letters.

## Configuration

This rule supports the following configuration options:

### `allow_consecutive_uppercase`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows consecutive uppercase letters in property names (e.g., `$httpURL` becomes valid).

### `allow_underscore_prefix`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows a single underscore prefix for property names (e.g., `$_privateProperty` becomes valid).

### `ignored_when_in_classes`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: An array of fully qualified class names to ignore. Properties in these specific classes will not be validated.

### `ignored_when_in_classes_descendant_of`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: An array of fully qualified class names. Properties in classes that extend any of these classes (or the classes themselves) will not be validated.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule

parameters:
    meliorstan:
        camel_case_property_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
            ignored_when_in_classes: []
            ignored_when_in_classes_descendant_of: []
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    // Valid property names
    private $userData; // ✓ Valid camelCase
    protected $httpResponse; // ✓ Valid camelCase
    public $isValid; // ✓ Valid camelCase
    private $firstName; // ✓ Valid camelCase
    
    // Invalid property names
    private $user_data; // ✗ Error: Property name "user_data" is not in camelCase.
    protected $HttpResponse; // ✗ Error: Property name "HttpResponse" is not in camelCase.
    public $ITEM_COUNT; // ✗ Error: Property name "ITEM_COUNT" is not in camelCase.
}
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    meliorstan:
        camel_case_property_name:
            allow_consecutive_uppercase: true
```

```php
class Example
{
    private $httpURL; // ✓ Now valid
    private $xmlAPI; // ✓ Now valid
}
```

#### Allow Underscore Prefix

```neon
parameters:
    meliorstan:
        camel_case_property_name:
            allow_underscore_prefix: true
```

```php
class Example
{
    private $_privateProperty; // ✓ Now valid
    protected $_internalData; // ✓ Now valid
}
```

#### Ignore Specific Classes

```neon
parameters:
    meliorstan:
        camel_case_property_name:
            ignored_when_in_classes:
                - 'My\Namespace\LegacyClass'
                - 'My\Namespace\ThirdPartyClass'
```

```php
class LegacyClass
{
    private $user_data; // ✓ Ignored - no error reported
    protected $HttpResponse; // ✓ Ignored - no error reported
}

class ThirdPartyClass
{
    public $ITEM_COUNT; // ✓ Ignored - no error reported
}

class RegularClass
{
    private $user_data; // ✗ Error: Property name "user_data" is not in camelCase.
}
```

#### Ignore Classes Descendant Of

```neon
parameters:
    meliorstan:
        camel_case_property_name:
            ignored_when_in_classes_descendant_of:
                - 'My\Namespace\BaseEntity'
```

```php
class BaseEntity
{
    protected $created_at; // ✓ Ignored - no error reported
}

class User extends BaseEntity
{
    private $first_name; // ✓ Ignored - no error reported
}

class Product extends BaseEntity
{
    public $item_count; // ✓ Ignored - no error reported
}

class RegularClass
{
    private $user_data; // ✗ Error: Property name "user_data" is not in camelCase.
}
```


