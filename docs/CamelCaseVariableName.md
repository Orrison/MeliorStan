# CamelCase Variable Name Rule

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
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\CamelCaseVariableName\CamelCaseVariableNameRule

parameters:
    messed_up:
        camel_case_variable_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
```

## Examples

### Valid Variable Names (Default Configuration)

```php
<?php

function processData($inputData) 
{
    $userData = [];
    $httpResponse = null;
    $isValid = true;
    $firstName = 'John';
    $itemCount = 0;
    
    foreach ($inputData as $currentItem) {
        $processedValue = transform($currentItem);
    }
}

class Example
{
    public function calculate()
    {
        $firstNumber = 10;
        $secondNumber = 20;
        $resultValue = $firstNumber + $secondNumber;
        return $resultValue;
    }
}
```

### Invalid Variable Names (Default Configuration)

```php
<?php

function processData($inputData) 
{
    $user_data = []; // ✗ Error: Variable name "user_data" is not in camelCase.
    $HttpResponse = null; // ✗ Error: Variable name "HttpResponse" is not in camelCase.
    $is_valid = true; // ✗ Error: Variable name "is_valid" is not in camelCase.
    $first_name = 'John'; // ✗ Error: Variable name "first_name" is not in camelCase.
    $ITEM_COUNT = 0; // ✗ Error: Variable name "ITEM_COUNT" is not in camelCase.
    
    foreach ($inputData as $current_item) { // ✗ Error: Variable name "current_item" is not in camelCase.
        $processed_value = transform($current_item); // ✗ Error: Variable name "processed_value" is not in camelCase.
    }
}
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    messed_up:
        camel_case_variable_name:
            allow_consecutive_uppercase: true
```

With this configuration:
```php
function processData() 
{
    $httpURL = 'https://example.com'; // ✓ Now valid
    $xmlData = parseXML($httpURL); // ✓ Now valid
    $apiHTTPResponse = callAPI($httpURL); // ✓ Now valid
}
```

#### Allow Underscore Prefix

```neon
parameters:
    messed_up:
        camel_case_variable_name:
            allow_underscore_prefix: true
```

With this configuration:
```php
function processData() 
{
    $_tempVariable = 'temporary'; // ✓ Now valid
    $_internalData = getData(); // ✓ Now valid
    $_privateValue = calculateValue(); // ✓ Now valid
}
```

## Important Notes

- This rule only applies to local variables within function and method bodies
- Global variables and superglobals are not affected by this rule
- Variables in global scope are not validated by this rule
- Parameter names are handled by the separate CamelCaseParameterName rule
- Property names are handled by the separate CamelCasePropertyName rule
