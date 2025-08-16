# MissingClosureParameterTypehint

Enforces that all parameters in anonymous functions (closures) have type declarations.

This rule ensures that anonymous functions maintain the same level of type safety as regular functions by requiring explicit type hints for all closure parameters. Type hints improve code readability, enable better IDE support, and help catch type-related errors during static analysis.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessStan\Rules\MissingClosureParameterTypehint\MissingClosureParameterTypehintRule
```

## Examples

### Default Configuration

```php
<?php

class ExampleClass
{
    public function processData()
    {
        // ✓ Valid - closure with typed parameters
        $validClosure = function (string $name, int $age): string {
            return $name . ' is ' . $age . ' years old';
        };

        // ✗ Error: Parameter #1 $name of anonymous function has no typehint.
        // ✗ Error: Parameter #2 $age of anonymous function has no typehint.
        $invalidClosure = function ($name, $age) {
            return $name . ' is ' . $age . ' years old';
        };

        // ✓ Valid - closure with no parameters
        $noParamsClosure = function (): string {
            return 'No parameters';
        };

        // ✓ Valid - using in array_map with typed parameter
        $numbers = [1, 2, 3];
        array_map(function (int $n): int {
            return $n * 2;
        }, $numbers);

        // ✗ Error: Parameter #1 $n of anonymous function has no typehint.
        array_map(function ($n) {
            return $n * 2;
        }, $numbers);

        // ✓ Valid - closure with reference parameter that has type
        $refClosure = function (string &$value): void {
            $value = strtoupper($value);
        };

        // ✗ Error: Parameter #1 $value of anonymous function has no typehint.
        $refUntypedClosure = function (&$value) {
            $value = strtoupper($value);
        };
    }
}
```

## Important Notes

- This rule only applies to anonymous functions (closures), not regular function or method declarations
- All parameters must have type hints; partial typing (some typed, some untyped) will still trigger errors for the untyped parameters
- Reference parameters (`&$param`) must also include type hints
- Closures with no parameters are always valid
