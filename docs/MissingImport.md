# MissingImport

Detects classes, interfaces, enums, and traits referenced by their fully qualified name (with a leading backslash) instead of being imported with a `use` statement.

Referencing types by their fully qualified name obscures a file's dependencies. Using `use` statements makes every dependency immediately visible at a glance and keeps call-site code shorter and more readable.

## Configuration

This rule supports the following configuration options:

### `ignore_global`

- **Type**: `bool`
- **Default**: `false`
- **Description**: When `true`, classes that live in PHP's global namespace (e.g. `\stdClass`, `\Exception`, `\DateTime`) are allowed to be referenced by their fully qualified name without a `use` statement. When `false` (default), global-namespace classes are treated the same as namespaced ones.

### `exceptions`

- **Type**: `string[]`
- **Default**: `[]`
- **Description**: A list of fully qualified class names (without the leading `\`) that are always allowed to be referenced as FQCNs, even when `ignore_global` is `false`. Useful for intentional or generated references that are exempt from this rule (e.g. `App\Providers\AppServiceProvider`).

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\MissingImport\MissingImportRule

parameters:
    meliorstan:
        missing_import:
            ignore_global: false
            exceptions: []
```

## Examples

### Default Configuration

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    // ✓ Valid (imported via use statement)
    private User $user;

    // ✓ Valid (imported via use statement)
    public function show(User $user): User
    {
        return new User();
    }

    // ✗ Error: Type "\App\Traits\Auditable" should not be referenced by its fully qualified name.
    use \App\Traits\Auditable;

    // ✗ Error: Type "\App\Models\UserStatus" should not be referenced by its fully qualified name.
    public const \App\Models\UserStatus DEFAULT_STATUS = \App\Models\UserStatus::Active;

    // ✗ Error: Type "\App\Services\UserService" should not be referenced by its fully qualified name.
    public function store(\App\Services\UserService $service): void {}

    // ✗ Error: Type "\App\Services\UserService" should not be referenced by its fully qualified name.
    public function index(): void
    {
        $service = new \App\Services\UserService();
        \App\Services\UserService::boot();
    }

    // ✗ Error: Type "\stdClass" should not be referenced by its fully qualified name.
    public function raw(): void
    {
        $obj = new \stdClass();
    }
}

// ✗ Error: Type "\App\Contracts\HasLabel" should not be referenced by its fully qualified name.
enum Status: string implements \App\Contracts\HasLabel
{
    case Active = 'active';

    // ✓ Valid (imported via use statement)
    public function label(User $user): string
    {
        return $this->value;
    }
}
```

### Configuration Examples

#### `ignore_global`

```neon
parameters:
    meliorstan:
        missing_import:
            ignore_global: true
```

```php
<?php

namespace App\Http\Controllers;

class UserController
{
    public function raw(): void
    {
        $obj = new \stdClass();   // ✓ Now valid
        $dt  = new \DateTime();   // ✓ Now valid
    }
}
```

#### `exceptions`

```neon
parameters:
    meliorstan:
        missing_import:
            exceptions:
                - App\Services\UserService
```

```php
<?php

namespace App\Http\Controllers;

class UserController
{
    // ✓ Now valid (listed in exceptions)
    public function index(): void
    {
        $service = new \App\Services\UserService();
    }
}
```

## Important Notes

The rule inspects fully qualified names in all common type-reference positions, including:

- Property type declarations (`private \Foo\Bar $prop`)
- Typed class constants in PHP 8.3+ (`public const \Foo\Bar NAME = ...`)
- Parameter type declarations (`function foo(\Foo\Bar $x)`)
- Return type declarations (`function foo(): \Foo\Bar`)
- Union, intersection, and nullable types (`\Foo\Bar|\Baz\Qux`, `?\Foo\Bar`)
- `new` expressions (`new \Foo\Bar()`)
- Static calls and property access (`\Foo\Bar::method()`, `\Foo\Bar::$prop`, `\Foo\Bar::CONST`)
- `instanceof` checks (`$x instanceof \Foo\Bar`)
- `catch` blocks (`catch (\Foo\Bar $e)`)
- Trait use inside a class or trait body (`use \Foo\Bar`)
- Class `extends` and `implements` (`class Foo extends \Bar implements \Baz`)
- Interface `extends` (`interface Foo extends \Bar`)
- Enum `implements` (`enum Foo implements \Bar`)

Names that were resolved from a `use` import (e.g. `SomeService` after `use App\Services\SomeService`) are never flagged, only names that were explicitly written with a leading backslash in the source code.
