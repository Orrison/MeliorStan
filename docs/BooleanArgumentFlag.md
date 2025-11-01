# BooleanArgumentFlag

Boolean parameters in functions and methods are often indicators that a function is doing more than one thing, violating the Single Responsibility Principle.

This rule detects boolean parameters in class methods, static methods, named functions, and closures. When a function or method accepts a boolean flag to control its behavior, it typically means the function has at least two different execution paths, suggesting it should be split into separate functions.

## Configuration

This rule supports the following configuration options:

### `ignored_in_classes`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: A list of fully-qualified class names where boolean parameters in methods are allowed. Only class methods are affected by this configuration; functions and closures are not ignored even when defined within ignored classes.

```php
// Example: 'App\\Service\\ConfigurationService'
```

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regular expression pattern to match function or method names that should be ignored. This applies to class methods and named functions. Closures are not affected by this pattern. Common patterns include setter methods or boolean query methods.

```php
// Example: '/^set/' to ignore all setter methods
// Example: '/^(is|has|should)/' to ignore boolean query methods
```

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\BooleanArgumentFlag\BooleanArgumentFlagRule

parameters:
    meliorstan:
        boolean_argument_flag:
            ignored_in_classes: []
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

class UserService
{
    // ✗ Error: Method "UserService::processUser()" has boolean parameter "$active" which may indicate the method has multiple responsibilities.
    public function processUser(User $user, bool $active)
    {
        if ($active) {
            $this->activateUser($user);
        } else {
            $this->deactivateUser($user);
        }
    }
    
    // ✗ Error: Method "UserService::save()" has boolean parameter "$validate" which may indicate the method has multiple responsibilities.
    public function save(User $user, bool $validate)
    {
    }
    
    // ✗ Error: Method "UserService::handleNullable()" has boolean parameter "$option" which may indicate the method has multiple responsibilities.
    public function handleNullable(?bool $option)
    {
    }
    
    // ✗ Error: Method "UserService::unionType()" has boolean parameter "$flag" which may indicate the method has multiple responsibilities.
    public function unionType(bool|null $flag)
    {
    }
    
    // ✓ Valid: No boolean parameters
    public function getUser(int $id): User
    {
    }
}

// ✗ Error: Function "processData()" has boolean parameter "$flag" which may indicate the function has multiple responsibilities.
function processData(array $data, bool $flag)
{
}

// ✗ Error: Closure has boolean parameter "$enabled" which may indicate the closure has multiple responsibilities.
$handler = function (string $name, bool $enabled) {
};
```

### Configuration Examples

#### Ignored Classes

Useful for specific classes where boolean flags are acceptable (e.g., configuration builders, option classes).

```neon
parameters:
    meliorstan:
        boolean_argument_flag:
            ignored_in_classes:
                - 'App\Service\ConfigurationBuilder'
                - 'App\Options\UserOptions'
            ignore_pattern: ''
```

```php
<?php

namespace App\Service;

class ConfigurationBuilder
{
    // ✓ Valid: Class is in the ignored list
    public function setDebugMode(bool $enabled)
    {
    }
    
    // ✓ Valid: Class is in the ignored list
    public function configure(string $key, bool $value)
    {
    }
}

class UserService
{
    // ✗ Error: Class not in the ignored list
    public function processUser(User $user, bool $active)
    {
    }
}

// ✗ Error: Functions are not affected by ignored_in_classes
function configure(string $key, bool $value)
{
}
```

#### Ignore Pattern

Useful for allowing boolean parameters in specific method patterns like setters or boolean query methods.

```neon
parameters:
    meliorstan:
        boolean_argument_flag:
            ignored_in_classes: []
            ignore_pattern: '/^set/'
```

```php
<?php

class UserService
{
    // ✓ Valid: Method name matches pattern /^set/
    public function setEnabled(bool $enabled)
    {
    }
    
    // ✓ Valid: Method name matches pattern /^set/
    public function setDebugMode(bool $debug)
    {
    }
    
    // ✗ Error: Method name does not match pattern
    public function processUser(User $user, bool $active)
    {
    }
}

// ✓ Valid: Function name matches pattern /^set/
function setGlobalConfig(string $key, bool $value)
{
}

// ✗ Error: Function name does not match pattern
function processData(array $data, bool $flag)
{
}
```

#### Multiple Patterns Example

```neon
parameters:
    meliorstan:
        boolean_argument_flag:
            ignored_in_classes: []
            ignore_pattern: '/^(set|with)/'
```

```php
<?php

class QueryBuilder
{
    // ✓ Valid: Matches pattern (starts with 'set')
    public function setDistinct(bool $distinct)
    {
    }
    
    // ✓ Valid: Matches pattern (starts with 'with')
    public function withDeleted(bool $includeDeleted)
    {
    }
    
    // ✗ Error: Does not match pattern
    public function execute(bool $async)
    {
    }
}
```

#### Combined Configuration

Both `ignored_in_classes` and `ignore_pattern` can be used together. A method is allowed if it matches EITHER condition.

```neon
parameters:
    meliorstan:
        boolean_argument_flag:
            ignored_in_classes:
                - 'App\Service\ConfigurationBuilder'
            ignore_pattern: '/^set/'
```

```php
<?php

namespace App\Service;

class ConfigurationBuilder
{
    // ✓ Valid: Class is ignored (matches ignored_in_classes)
    public function process(bool $flag)
    {
    }
    
    // ✓ Valid: Method name matches pattern AND class is ignored (both conditions)
    public function setDebug(bool $debug)
    {
    }
}

class UserService
{
    // ✓ Valid: Method name matches pattern (matches ignore_pattern)
    public function setActive(bool $active)
    {
    }
    
    // ✗ Error: Neither condition is met
    public function process(bool $flag)
    {
    }
}

// ✓ Valid: Function name matches pattern
function setConfig(bool $value)
{
}

// ✗ Error: Does not match pattern (functions don't use ignored_in_classes)
function processConfig(bool $value)
{
}
```

## Important Notes

- **Union Types**: Any type hint that includes `bool` will be flagged, including `bool|null`, `int|bool`, `string|bool`, etc.
- **Nullable Booleans**: Both `bool` and `?bool` type hints are detected
- **Closures**: Anonymous functions and arrow functions are checked for boolean parameters
- **Magic Methods**: Magic methods like `__construct`, `__set`, etc. are also checked and will be flagged if they have boolean parameters
- **Class Scope**: The `ignored_in_classes` configuration only applies to class methods. Functions and closures defined within an ignored class are still checked unless they match the `ignore_pattern`
