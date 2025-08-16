# CamelCaseParameterName

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
    - vendor/orrison/messstan/config/extension.neon

rules:
    - Orrison\MessStan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule

parameters:
    mess_stan:
        camel_case_parameter_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function process($userData, $httpResponse, $isValid) 
    {
        // ✓ Valid camelCase parameters
    }
    
    public function calculate($user_data, $HttpResponse, $SECOND_NUMBER) 
    {
        // ✗ Error: Parameter name "user_data" is not in camelCase.
        // ✗ Error: Parameter name "HttpResponse" is not in camelCase.
        // ✗ Error: Parameter name "SECOND_NUMBER" is not in camelCase.
    }
}

function processData($inputData, $outputFormat) 
{
    // ✓ Valid camelCase parameters
}
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    mess_stan:
        camel_case_parameter_name:
            allow_consecutive_uppercase: true
```

```php
public function process($httpURL, $xmlAPI) {} // ✓ Now valid
```

#### Allow Underscore Prefix

```neon
parameters:
    mess_stan:
        camel_case_parameter_name:
            allow_underscore_prefix: true
```

```php
public function process($_privateParam, $_internalData) {} // ✓ Now valid
```
