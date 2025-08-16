# PascalCaseClassName

Enforces that class names should follow PascalCase naming convention.

This rule validates that all class names follow the PascalCase pattern, where the first letter is uppercase and subsequent words also start with uppercase letters. This applies to classes, interfaces, traits, and enums.

## Configuration

This rule supports the following configuration option:

### `allow_consecutive_uppercase`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, allows consecutive uppercase letters in class names (e.g., `HTTPClient` becomes valid).

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messstan/config/extension.neon

rules:
    - Orrison\MessStan\Rules\PascalCaseClassName\PascalCaseClassNameRule

parameters:
    mess_stan:
        pascal_case_class_name:
            allow_consecutive_uppercase: false
```

## Examples

### Default Configuration

```php
<?php

// Valid class names
class UserController {} // ✓ Valid PascalCase
class HttpResponse {} // ✓ Valid PascalCase
class DatabaseConnection {} // ✓ Valid PascalCase
interface PaymentProcessorInterface {} // ✓ Valid PascalCase

// Invalid class names
class userController {} // ✗ Error: Class name "userController" is not in PascalCase.
class user_controller {} // ✗ Error: Class name "user_controller" is not in PascalCase.
class HTTPClient {} // ✗ Error: Class name "HTTPClient" is not in PascalCase (consecutive uppercase not allowed by default).
trait logging_trait {} // ✗ Error: Trait name "logging_trait" is not in PascalCase.
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    mess_stan:
        pascal_case_class_name:
            allow_consecutive_uppercase: true
```

```php
class HTTPClient {} // ✓ Now valid
class XMLParser {} // ✓ Now valid
interface APIClientInterface {} // ✓ Now valid
```

## Important Notes

- This rule applies to all class-like structures: classes, interfaces, traits, and enums
- Anonymous classes are not validated by this rule
- The rule only validates the class name itself, not namespaces or fully qualified names
- Class names should start with an uppercase letter regardless of configuration
- When `allow_consecutive_uppercase` is `false`, acronyms should be treated as regular words (e.g., use `HttpClient` instead of `HTTPClient`)
