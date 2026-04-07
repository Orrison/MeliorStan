# UnusedLocalVariable

Detects local variables that are assigned inside a function, method, or closure but never read.

This rule fills a gap in PHPStan's built-in analysis: PHPStan's dead-code detection focuses on class-level constructs (unused private methods, unused properties, etc.) and does not flag unused local variables in function bodies. This rule mirrors the behavior of PHPMD's `UnusedLocalVariable` rule so you can keep code free of dead local assignments.

The rule analyzes each function-like (named functions, methods, closures, and arrow functions) in isolation. Variables assigned in one scope are not compared against reads in another scope.

## Configuration

This rule supports the following configuration options:

### `allow_unused_foreach_variables`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When enabled, unused `foreach` key/value variables are not reported. Useful when you commonly write `foreach ($items as $key => $value)` but only use one of the two.

### `exceptions`
- **Type**: `string[]`
- **Default**: `[]`
- **Description**: A list of variable names (without the `$` prefix) that should never be reported as unused. Useful for conventional throwaway names.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\UnusedLocalVariable\UnusedLocalVariableRule

parameters:
    meliorstan:
        unused_local_variable:
            allow_unused_foreach_variables: false
            exceptions: []
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function calculate(): int
    {
        $used = 1;
        $unused = 2; // ✗ Error: Avoid unused local variable "$unused".

        return $used;
    }

    public function viaCompact(): array
    {
        $a = 1;
        $b = 2;

        return compact('a', 'b'); // ✓ Valid — compact() string args count as reads.
    }

    public function interpolation(): string
    {
        $name = 'world';

        return "hello {$name}"; // ✓ Valid — variables in interpolated strings count as reads.
    }

    public function destructuring(): int
    {
        [$first, $second] = [1, 2]; // ✗ Error: Avoid unused local variable "$second".

        return $first;
    }

    public function foreachUnusedKey(array $items): int
    {
        $sum = 0;

        // ✗ Error: Avoid unused local variable "$key".
        foreach ($items as $key => $value) {
            $sum += $value;
        }

        return $sum;
    }
}
```

### Configuration Examples

#### Allow Unused Foreach Variables

```neon
parameters:
    meliorstan:
        unused_local_variable:
            allow_unused_foreach_variables: true
```

```php
<?php

function sum(array $items): int
{
    $sum = 0;

    // ✓ Now valid
    foreach ($items as $key => $value) {
        $sum += $value;
    }

    return $sum;
}
```

#### Exceptions List

```neon
parameters:
    meliorstan:
        unused_local_variable:
            exceptions: ['unused', 'tmp']
```

```php
<?php

function example(): int
{
    $unused = 1; // ✓ Now valid — name is in exceptions list.
    $tmp = 2;    // ✓ Now valid — name is in exceptions list.

    return 0;
}
```

## Important Notes

- **Scope**: The rule operates per function-like (function, method, closure). Each scope is analyzed independently. Nested function-likes are analyzed on their own and do not share state with their enclosing scope.
- **Parameters**: Formal parameters are intentionally not reported by this rule. They are the responsibility of a separate concern (`UnusedFormalParameter`-style rule).
- **Variable variables**: When a function body contains a variable variable like `$$name` or `${$expr}`, the rule cannot statically determine which locals it references. To avoid false positives, the rule emits no errors at all for that scope.
- **`compact()`**: String literal arguments to `compact()` are recognized as reads of the corresponding local variables.
- **`catch` variables**: The variable in a `catch` block is always treated as used, even if the catch body never references it.
- **`global` and `static` declarations**: Variables introduced via `global $x;` or `static $x = ...;` are always treated as used because they cross scope boundaries.
- **Closure `use` clauses**: Variables imported by a closure via `use ($var)` (or `use (&$var)`) are treated as reads of the outer scope variable. Arrow functions automatically capture by value, so any outer variable referenced inside the arrow body is also treated as a read.
- **String interpolation**: Variables embedded in double-quoted strings (e.g. `"hello $name"` or `"hi {$user->name}"`) count as reads.
- **By-reference**: Passing a variable to a function (whether by value or by reference) counts as a read of that variable.
