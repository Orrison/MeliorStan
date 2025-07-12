# PascalCase Class Name Rule

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
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\PascalCaseClassName\PascalCaseClassNameRule

parameters:
    messed_up:
        pascal_case_class_name:
            allow_consecutive_uppercase: false
```

## Examples

### Valid Class Names (Default Configuration)

```php
<?php

class UserController {} // ✓ Valid PascalCase
class HttpResponse {} // ✓ Valid PascalCase
class DatabaseConnection {} // ✓ Valid PascalCase
class JsonParser {} // ✓ Valid PascalCase

interface PaymentProcessorInterface {} // ✓ Valid PascalCase
trait LoggingTrait {} // ✓ Valid PascalCase
enum StatusEnum {} // ✓ Valid PascalCase

abstract class AbstractBaseClass {} // ✓ Valid PascalCase
```

### Invalid Class Names (Default Configuration)

```php
<?php

class userController {} // ✗ Error: Class name "userController" is not in PascalCase.
class user_controller {} // ✗ Error: Class name "user_controller" is not in PascalCase.
class USER_CONTROLLER {} // ✗ Error: Class name "USER_CONTROLLER" is not in PascalCase.
class HTTPClient {} // ✗ Error: Class name "HTTPClient" is not in PascalCase (consecutive uppercase not allowed by default).
class XMLParser {} // ✗ Error: Class name "XMLParser" is not in PascalCase (consecutive uppercase not allowed by default).

interface payment_processor_interface {} // ✗ Error: Interface name "payment_processor_interface" is not in PascalCase.
trait logging_trait {} // ✗ Error: Trait name "logging_trait" is not in PascalCase.
enum status_enum {} // ✗ Error: Enum name "status_enum" is not in PascalCase.
```

### Configuration Examples

#### Allow Consecutive Uppercase

```neon
parameters:
    messed_up:
        pascal_case_class_name:
            allow_consecutive_uppercase: true
```

With this configuration:
```php
class HTTPClient {} // ✓ Now valid
class XMLParser {} // ✓ Now valid
class JSONProcessor {} // ✓ Now valid
class APIController {} // ✓ Now valid
class URLBuilder {} // ✓ Now valid

interface HTTPClientInterface {} // ✓ Now valid
trait XMLParserTrait {} // ✓ Now valid
enum HTTPStatusEnum {} // ✓ Now valid
```

## Important Notes

- This rule applies to all class-like structures: classes, interfaces, traits, and enums
- Anonymous classes are not validated by this rule
- The rule only validates the class name itself, not namespaces or fully qualified names
- Class names should start with an uppercase letter regardless of configuration
- When `allow_consecutive_uppercase` is `false`, acronyms should be treated as regular words (e.g., use `HttpClient` instead of `HTTPClient`)
