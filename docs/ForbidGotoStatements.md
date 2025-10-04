# ForbidGotoStatements

Detects and reports usage of `goto` statements in code.

The `goto` statement is generally considered harmful as it can make code difficult to understand and maintain by allowing arbitrary jumps in program flow. This rule helps enforce structured programming practices by flagging all `goto` statement usage.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ForbidGotoStatements\ForbidGotoStatementsRule
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function method(): void
    {
        $i = 0;
        
        start:
        echo $i;
        $i++;
        
        if ($i < 5) {
            goto start; // ✗ Error: Goto statements should not be used.
        }
    }
    
    public function anotherMethod(): void
    {
        if (someCondition()) {
            goto skip; // ✗ Error: Goto statements should not be used.
        }
        
        // Some code
        
        skip:
        return;
    }
    
    public function validMethod(): void
    {
        // ✓ Valid - no goto statements
        for ($i = 0; $i < 10; $i++) {
            if ($i === 5) {
                break; // Use structured control flow instead
            }
        }
    }
}
```

## Important Notes

- This rule reports **all** `goto` statements without exception
- Consider using structured control flow alternatives like loops, conditionals, early returns, or exceptions instead of `goto`
- While PHP supports `goto`, it is generally recommended to avoid it in favor of more maintainable code patterns
