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

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessStan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule

parameters:
    messed_up:
        camel_case_property_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
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
    messed_up:
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
    messed_up:
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


