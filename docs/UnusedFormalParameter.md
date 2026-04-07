# UnusedFormalParameter

Detects formal parameters declared on functions, methods, and closures that are never read inside the body.

This rule mirrors PHPMD's `UnusedFormalParameter` rule. PHPStan's built-in dead-code detection covers unused private methods and properties but does not flag unused parameters, so this rule fills that gap. The rule analyzes each function-like (named functions, methods, closures, arrow functions) in isolation.

## Configuration

This rule supports the following configuration options:

### `allow_unused_with_inheritdoc`
- **Type**: `bool`
- **Default**: `true`
- **Description**: When enabled, methods whose PHPDoc contains `@inheritdoc` (or `{@inheritdoc}`) are skipped. This is useful for child methods that must keep the parent's signature even when they ignore some parameters.

### `allow_overriding_methods`
- **Type**: `bool`
- **Default**: `true`
- **Description**: When enabled, methods that override a method declared on a parent class or implemented interface are skipped. The signature is fixed by the contract, so unused parameters are usually intentional.

### `exceptions`
- **Type**: `string[]`
- **Default**: `[]`
- **Description**: A list of parameter names (without the `$` prefix) that should never be reported as unused. Useful for conventional throwaway names.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\UnusedFormalParameter\UnusedFormalParameterRule

parameters:
    meliorstan:
        unused_formal_parameter:
            allow_unused_with_inheritdoc: true
            allow_overriding_methods: true
            exceptions: []
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function calculate(int $used, int $unused): int // ✗ Error: Avoid unused parameter "$unused".
    {
        return $used + 1;
    }

    public function viaCompact(int $a, int $b): array
    {
        return compact('a', 'b'); // ✓ Valid — compact() string args count as reads.
    }

    public function variadicLike(int $a, int $b, int $c): array
    {
        return func_get_args(); // ✓ Valid — func_get_args() suppresses reporting for the whole scope.
    }

    public function __construct(public int $x) // ✓ Valid — promoted constructor params become properties.
    {
    }

    public function magic(string $name, mixed $value): void
    {
        // ✓ Valid — magic methods (__set, __call, etc.) are never reported.
    }

    public function withClosure(int $outer): \Closure
    {
        return function () use ($outer) { // ✓ Valid — closure use clause counts as a read.
            return $outer + 1;
        };
    }
}
```

### Configuration Examples

#### Disallow `@inheritdoc` Suppression

```neon
parameters:
    meliorstan:
        unused_formal_parameter:
            allow_unused_with_inheritdoc: false
```

```php
<?php

class Child extends Parent
{
    /**
     * @inheritdoc
     */
    public function handle(int $value, string $name): void // ✗ Error: Avoid unused parameter "$name".
    {
        echo $value;
    }
}
```

#### Disallow Overriding Method Suppression

```neon
parameters:
    meliorstan:
        unused_formal_parameter:
            allow_overriding_methods: false
```

```php
<?php

class Child extends Parent
{
    public function process(int $value, string $name): void // ✗ Error: Avoid unused parameter "$name".
    {
        echo $value;
    }
}
```

#### Exceptions List

```neon
parameters:
    meliorstan:
        unused_formal_parameter:
            exceptions: ['unused']
```

```php
<?php

function example(int $used, int $unused): int
{
    // ✓ Now valid — "unused" is in the exceptions list.
    return $used;
}
```

## Important Notes

- **Scope**: The rule operates per function-like (function, method, closure, arrow function). Nested function-likes are analyzed independently and do not share state with their enclosing scope.
- **Abstract and interface methods**: Methods without a body (abstract methods, interface methods) are never reported.
- **Magic methods**: PHP magic methods (`__construct`, `__call`, `__set`, `__get`, etc.) are always skipped because their parameter lists are fixed by PHP.
- **Promoted constructor properties**: Constructor parameters with a visibility modifier (`public`, `protected`, `private`) become real object properties and are never reported.
- **`func_get_args()` family**: When the body calls `func_get_args()`, `func_get_arg()`, or `func_num_args()`, no parameters are reported for that scope because they are accessed dynamically.
- **`compact()`**: String literal arguments to `compact()` are recognized as reads of the corresponding parameters.
- **Variable variables**: When the body contains a variable variable like `$$name` or `${$expr}`, no parameters are reported for that scope to avoid false positives.
- **Closure `use` clauses**: A nested closure's `use ($outer)` clause counts as a read of the outer-scope parameter.
- **Arrow functions**: Arrow functions auto-capture by value, so any outer parameter referenced inside the arrow body counts as a read.
- **By-reference parameters**: `&$out` parameters are checked normally. If a function only writes to a by-reference parameter and never reads it, that is still reported. Use the `exceptions` list to opt out per-name if this is noisy.
- **Variadic parameters**: Variadic parameters (`...$values`) are checked normally and reported if their bound array is never read.
