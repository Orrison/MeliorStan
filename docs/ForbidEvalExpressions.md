# ForbidEvalExpressions

Detects and reports usage of `eval()` expressions in code.

The `eval()` language construct is extremely dangerous because it allows execution of arbitrary PHP code. Using `eval()` can introduce security vulnerabilities, make code difficult to debug and maintain, and negatively impact performance. This rule helps enforce safer coding practices by flagging all `eval()` expression usage.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ForbidEvalExpressions\ForbidEvalExpressionsRule
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function method(): void
    {
        $code = 'echo "Hello";';
        eval($code); // ✗ Error: Eval expressions should not be used.
    }
    
    public function anotherMethod(): void
    {
        eval('$x = 10; echo $x;'); // ✗ Error: Eval expressions should not be used.
    }
    
    public function validMethod(): void
    {
        // ✓ Valid - use proper code structure instead
        $x = 10;
        echo $x;
        
        // ✓ Valid - use callbacks or closures for dynamic behavior
        $callback = fn() => echo "Hello";
        $callback();
    }
}
```

## Important Notes

- This rule reports **all** `eval()` expressions without exception
- `eval()` is often a sign of poor design and can almost always be replaced with better alternatives
- Security risk: `eval()` can execute arbitrary code, making it a prime target for code injection attacks
- Performance impact: Code executed via `eval()` cannot be cached by opcode caches
- Consider alternatives such as:
  - Proper control structures (if/switch statements)
  - Callbacks and closures
  - Strategy pattern for dynamic behavior
  - Configuration files for dynamic settings
  - Template engines for dynamic output
