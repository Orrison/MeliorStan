# StaticAccess

Static access creates hard-to-replace dependencies on other classes and leads to hard-to-test code.

This rule detects static method calls (e.g., `SomeClass::doSomething()`) and optionally static property access (e.g., `SomeClass::$value`). Static access creates tight coupling between classes, making it difficult to substitute dependencies during testing or when requirements change. The recommended approach is to inject dependencies through constructors instead.

Calls to `self::`, `static::`, and `parent::` are always excluded since they reference the current class hierarchy and are not external dependencies.

## Configuration

This rule supports the following configuration options:

### `exceptions`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: A list of fully-qualified class names to exclude from this rule. Supports wildcard patterns using `*` (e.g., `Illuminate\Support\Facades\*` to exclude all Laravel facades). Class names should not include a leading backslash.

### `method_ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regular expression pattern to match method names that should be ignored. This is useful for allowing factory methods while still flagging other static access.

```php
// Example: '/^(create|make|from|of)/' to ignore common factory method patterns
```

### `property_ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regular expression pattern to match property names that should be ignored. Only applies when `check_static_property_access` is enabled.

```php
// Example: '/^(config|default)/' to ignore configuration-style static properties
```

### `check_static_property_access`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, also flags static property access (`ClassName::$property`) in addition to static method calls.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule

parameters:
    meliorstan:
        static_access:
            exceptions: []
            method_ignore_pattern: ''
            property_ignore_pattern: ''
            check_static_property_access: false
```

## Examples

### Default Configuration

```php
<?php

class UserService
{
    public static function helper(): void {}

    public function process(): void
    {
        Logger::info('processing');       // ✗ Error: Avoid using static access to "Logger::info()". Use dependency injection instead.
        Cache::get('key');                // ✗ Error: Avoid using static access to "Cache::get()". Use dependency injection instead.
        self::helper();                   // ✓ Valid, self reference
        static::helper();                // ✓ Valid, static reference
        parent::process();               // ✓ Valid, parent reference
    }
}
```

### Configuration Examples

#### Exceptions

```neon
parameters:
    meliorstan:
        static_access:
            exceptions:
                - App\Helpers\StringHelper
                - Illuminate\Support\Facades\*
```

```php
<?php

use Illuminate\Support\Facades\Cache;

class UserService
{
    public function process(): void
    {
        StringHelper::trim('value');       // ✓ Now valid, exact match exception
        Cache::get('key');                 // ✓ Now valid, wildcard match on Illuminate\Support\Facades\*
        Logger::info('processing');        // ✗ Error, not in exceptions list
    }
}
```

#### Method Ignore Pattern

```neon
parameters:
    meliorstan:
        static_access:
            method_ignore_pattern: '/^(create|make|from)/'
```

```php
<?php

class OrderService
{
    public function process(): void
    {
        Order::create($data);             // ✓ Now valid, method name matches pattern
        Collection::make([1, 2, 3]);      // ✓ Now valid, method name matches pattern
        Carbon::fromTimestamp(time());     // ✓ Now valid, method name matches pattern
        Logger::info('processing');        // ✗ Error, method name does not match pattern
    }
}
```

#### Check Static Property Access with Property Ignore Pattern

```neon
parameters:
    meliorstan:
        static_access:
            check_static_property_access: true
            property_ignore_pattern: '/^(config|default)/'
```

```php
<?php

class ReportService
{
    protected static string $name = 'report';

    public function process(): void
    {
        Config::$debug;                   // ✗ Error: Avoid using static access to "Config::$debug". Use dependency injection instead.
        Settings::$configPath;            // ✓ Now valid, property name matches pattern
        Settings::$defaultTimeout;        // ✓ Now valid, property name matches pattern
        Logger::info('processing');        // ✗ Error: Avoid using static access to "Logger::info()". Use dependency injection instead.
        self::$name;                      // ✓ Valid, self reference
        static::$name;                    // ✓ Valid, static reference
    }
}
```

## Important Notes

- Class names in the `exceptions` configuration should be fully-qualified without a leading backslash (e.g., `App\Services\MyService`, not `\App\Services\MyService`).
- The `*` wildcard in exceptions matches any characters, making it easy to exclude entire namespaces.
- Dynamic static calls (e.g., `$className::method()`) are not detected since the class name cannot be determined from the AST alone.
- The `method_ignore_pattern` only applies to static method calls, and `property_ignore_pattern` only applies to static property access.
- The `property_ignore_pattern` has no effect unless `check_static_property_access` is enabled.
