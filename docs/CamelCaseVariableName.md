# CamelCaseVariableName

Enforces that local variable names should follow camelCase naming convention.

This rule validates that all local variable names follow the camelCase pattern, where the first letter is lowercase and subsequent words start with uppercase letters. This includes variables in function bodies, method bodies, and other local scopes.

## Configuration

This rule supports the following configuration options:

### `allow_consecutive_uppercase`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows consecutive uppercase letters in variable names (e.g., `$httpURL` becomes valid).

### `allow_underscore_prefix`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows a single underscore prefix for variable names (e.g., `$_tempVariable` becomes valid).

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messstan/config/extension.neon

rules:
    - Orrison\MessStan\Rules\CamelCaseVariableName\CamelCaseVariableNameRule

parameters:
    mess_stan:
        camel_case_variable_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
```

## Examples

### Default Configuration

```php
<?php

function processData($inputData) 
{
    // Valid variable names
    $userData = [];
    $httpResponse = null;
    $isValid = true;
    $firstName = 'John';
    
    // Invalid variable names
    $user_data = []; // ✗ Error: Variable name "user_data" is not in camelCase.
    $HttpResponse = null; // ✗ Error: Variable name "HttpResponse" is not in camelCase.
    $ITEM_COUNT = 0; // ✗ Error: Variable name "ITEM_COUNT" is not in camelCase.
    
    foreach ($inputData as $currentItem) { // ✓ Valid
        $processed_value = transform($currentItem); // ✗ Error: Variable name "processed_value" is not in camelCase.
    }
}
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    mess_stan:
        camel_case_variable_name:
            allow_consecutive_uppercase: true
```

```php
function processData() 
{
    $httpURL = 'https://example.com'; // ✓ Now valid
    $xmlAPI = parseAPI($httpURL); // ✓ Now valid
}
```

#### Allow Underscore Prefix

```neon
parameters:
    mess_stan:
        camel_case_variable_name:
            allow_underscore_prefix: true
```

```php
function processData() 
{
    $_tempVariable = 'temporary'; // ✓ Now valid
    $_internalData = getData(); // ✓ Now valid
}
```

## Important Notes

- This rule only applies to local variables within function and method bodies
- Global variables and superglobals are not affected by this rule
- Variables in global scope are not validated by this rule
- Parameter names are handled by the separate CamelCaseParameterName rule
- Property names are handled by the separate CamelCasePropertyName rule
