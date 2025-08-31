# ElseExpression

Enforces avoidance of `else` expressions, following Object Calisthenics principles.

This rule flags `else` and optionally `elseif` expressions to encourage refactoring with guard clauses or early returns.

## Configuration

This rule supports the following configuration options:

### `elseif_allowed`
- **Type**: `bool`
- **Default**: `true`
- **Description**: If `true`, `elseif` expressions are allowed and not flagged. If `false`, `elseif` expressions are flagged.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ElseExpression\ElseExpressionRule

parameters:
    meliorstan:
        else_expression:
            elseif_allowed: true
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function method(): void
    {
        if ($condition) {
            doSomething();
        }  // ✓ Valid: no else

        if ($condition) {
            doSomething();
        } elseif ($other) {  // ✓ Valid: elseif allowed
            doOther();
        }

        if ($condition) {
            doSomething();
        } else {  // ✗ Error: Avoid using else expressions.
            doDefault();
        }
    }
}
```

### Configuration Examples

#### Elseif Not Allowed

```neon
parameters:
    meliorstan:
        else_expression:
            elseif_allowed: false
```

```php
if ($condition) {
    doSomething();
} elseif ($other) {  // ✗ Error: Avoid using else expressions.
    doOther();
}
```
