# CamelCase Parameter Name Rule

Enforces that function and method parameter names should follow camelCase naming convention.

This rule validates that all parameter names in functions and methods follow the camelCase pattern, where the first letter is lowercase and subsequent words start with uppercase letters.

## Configuration

This rule supports the following configuration options:

### `allow_consecutive_uppercase`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows consecutive uppercase letters in parameter names (e.g., `$httpURL` becomes valid).

### `allow_underscore_prefix`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows a single underscore prefix for parameter names (e.g., `$_privateParam` becomes valid).

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule

parameters:
    messed_up:
        camel_case_parameter_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
```

## Examples

### Valid Parameter Names (Default Configuration)

```php
<?php

class Example
{
    public function process($userData, $httpResponse, $isValid) 
    {
        // All parameters follow camelCase
    }
    
    public function calculate($firstNumber, $secondNumber) 
    {
        // Valid camelCase parameters
    }
}

function processData($inputData, $outputFormat) 
{
    // Valid camelCase parameters
}
```

### Invalid Parameter Names (Default Configuration)

```php
<?php

class Example
{
    public function process($user_data, $HttpResponse, $is_valid) 
    {
        // ✗ Error: Parameter name "user_data" is not in camelCase.
        // ✗ Error: Parameter name "HttpResponse" is not in camelCase.
        // ✗ Error: Parameter name "is_valid" is not in camelCase.
    }
    
    public function calculate($first_number, $SECOND_NUMBER) 
    {
        // ✗ Error: Parameter name "first_number" is not in camelCase.
        // ✗ Error: Parameter name "SECOND_NUMBER" is not in camelCase.
    }
}
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    messed_up:
        camel_case_parameter_name:
            allow_consecutive_uppercase: true
```

With this configuration:
```php
public function process($httpURL, $xmlData) {} // ✓ Now valid
public function handle($apiHTTPResponse) {} // ✓ Now valid
```

#### Allow Underscore Prefix

```neon
parameters:
    messed_up:
        camel_case_parameter_name:
            allow_underscore_prefix: true
```

With this configuration:
```php
public function process($_privateParam, $_internalData) {} // ✓ Now valid
public function handle($_tempValue) {} // ✓ Now valid
```
