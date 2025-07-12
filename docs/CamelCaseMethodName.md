# CamelCase Method Name Rule

Enforces that method names should follow camelCase naming convention.

This rule validates that all method names in classes follow the camelCase pattern, where the first letter is lowercase and subsequent words start with uppercase letters.

## Configuration

This rule supports the following configuration options:

### `allow_consecutive_uppercase`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows consecutive uppercase letters in method names (e.g., `getHTTPResponse` becomes valid).

### `allow_underscore_in_tests`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows underscores in test method names that start with "test" (e.g., `test_with_underscores` becomes valid).

### `allow_underscore_prefix`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows a single underscore prefix for method names (e.g., `_privateMethod` becomes valid).

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule

parameters:
    messed_up:
        camel_case_method_name:
            allow_consecutive_uppercase: false
            allow_underscore_in_tests: false
            allow_underscore_prefix: false
```

## Examples

### Valid Method Names (Default Configuration)

```php
<?php

class Example
{
    public function doSomething() {} // ✓ Valid camelCase
    public function getHttpResponse() {} // ✓ Valid camelCase
    public function testMethod() {} // ✓ Valid camelCase
    
    // Magic methods are always ignored
    public function __construct() {} // ✓ Always valid
    public function __destruct() {} // ✓ Always valid
}
```

### Invalid Method Names (Default Configuration)

```php
<?php

class Example
{
    public function do_something_invalid() {} // ✗ Error: Method name "do_something_invalid" is not in camelCase.
    public function DoSomethingInvalid() {} // ✗ Error: Method name "DoSomethingInvalid" is not in camelCase.
    public function getHTTPResponseInvalid() {} // ✗ Error: Method name "getHTTPResponseInvalid" is not in camelCase.
    public function test_with_underscores_invalid() {} // ✗ Error: Method name "test_with_underscores_invalid" is not in camelCase.
}
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    messed_up:
        camel_case_method_name:
            allow_consecutive_uppercase: true
```

With this configuration:
```php
public function getHTTPResponse() {} // ✓ Now valid
public function getXMLData() {} // ✓ Now valid
```

#### Allow Underscores in Tests

```neon
parameters:
    messed_up:
        camel_case_method_name:
            allow_underscore_in_tests: true
```

With this configuration:
```php
public function test_with_underscores() {} // ✓ Now valid (starts with "test")
public function testAnotherMethod() {} // ✓ Still valid
```

#### Allow Underscore Prefix

```neon
parameters:
    messed_up:
        camel_case_method_name:
            allow_underscore_prefix: true
```

With this configuration:
```php
public function _privateMethod() {} // ✓ Now valid
public function _getData() {} // ✓ Now valid
```
