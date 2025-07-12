# CamelCase Property Name Rule

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
    - Orrison\MessedUpPhpstan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule

parameters:
    messed_up:
        camel_case_property_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
```

## Examples

### Valid Property Names (Default Configuration)

```php
<?php

class Example
{
    private $userData;
    protected $httpResponse;
    public $isValid;
    private $firstName;
    public $itemCount;
}
```

### Invalid Property Names (Default Configuration)

```php
<?php

class Example
{
    private $user_data; // ✗ Error: Property name "user_data" is not in camelCase.
    protected $HttpResponse; // ✗ Error: Property name "HttpResponse" is not in camelCase.
    public $is_valid; // ✗ Error: Property name "is_valid" is not in camelCase.
    private $first_name; // ✗ Error: Property name "first_name" is not in camelCase.
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

With this configuration:
```php
class Example
{
    private $httpURL; // ✓ Now valid
    protected $xmlData; // ✓ Now valid
    public $apiHTTPResponse; // ✓ Now valid
}
```

#### Allow Underscore Prefix

```neon
parameters:
    messed_up:
        camel_case_property_name:
            allow_underscore_prefix: true
```

With this configuration:
```php
class Example
{
    private $_privateProperty; // ✓ Now valid
    protected $_internalData; // ✓ Now valid
    public $_tempValue; // ✓ Now valid
}
```


