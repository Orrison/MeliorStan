# DevelopmentCodeFragment

Detects calls to development and debugging functions that should not appear in production code.

Functions like `var_dump()`, `print_r()`, `dd()`, `dump()`, and `ray()` are typically used during development and are often accidentally left in production code. This rule flags these calls so they can be removed before deployment.

## Configuration

This rule supports the following configuration options:

### `unwanted_functions`
- **Type**: `array` of `string`
- **Default**: `['var_dump', 'print_r', 'debug_zval_dump', 'debug_print_backtrace', 'dd', 'dump', 'ray']`
- **Description**: A list of function names to flag as development code. When set to a non-empty array, this completely replaces the default list. Function name matching is case-insensitive.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\DevelopmentCodeFragment\DevelopmentCodeFragmentRule
```

## Examples

### Default Configuration

```php
<?php

class UserService
{
    public function getUser(int $id): array
    {
        $user = $this->findUser($id);
        var_dump($user);              // ✗ Error: Call to development/debug function var_dump() is discouraged.
        print_r($user);              // ✗ Error: Call to development/debug function print_r() is discouraged.
        debug_zval_dump($user);      // ✗ Error: Call to development/debug function debug_zval_dump() is discouraged.
        debug_print_backtrace();     // ✗ Error: Call to development/debug function debug_print_backtrace() is discouraged.
        dd($user);                   // ✗ Error: Call to development/debug function dd() is discouraged.
        dump($user);                 // ✗ Error: Call to development/debug function dump() is discouraged.
        ray($user);                  // ✗ Error: Call to development/debug function ray() is discouraged.

        echo $user['name'];         // ✓ Valid
        count($user);               // ✓ Valid
        array_map(fn ($v) => $v, $user); // ✓ Valid

        return $user;
    }
}
```

### Configuration Examples

#### Custom Unwanted Functions

Override the default list to flag framework-specific debug helpers instead:

```neon
parameters:
    meliorstan:
        development_code_fragment:
            unwanted_functions:
                - dump
                - dd
```

```php
<?php

class Example
{
    public function process(array $data): void
    {
        dump($data);     // ✗ Error: Call to development/debug function dump() is discouraged.
        dd($data);       // ✗ Error: Call to development/debug function dd() is discouraged.
        var_dump($data); // ✓ Now valid (not in custom list)
    }
}
```

## Important Notes

- Setting `unwanted_functions` to a non-empty list **replaces** the defaults entirely; it does not merge with them. To keep the defaults and add more, include all desired function names in your list.
- Function name matching is case-insensitive (`VAR_DUMP` and `var_dump` are treated the same).
- This rule only detects direct function calls. It does not detect calls made via variables (e.g., `$fn = 'var_dump'; $fn($data);`).
