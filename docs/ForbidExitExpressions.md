# ForbidExitExpressions

Detects and reports usage of `exit` and `die` expressions in code.

Using `exit` or `die` constructs can make code difficult to test and debug, as they immediately terminate script execution. This rule helps enforce better error handling practices by flagging all `exit` and `die` expression usage. Consider using exceptions or proper return values instead.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ForbidExitExpressions\ForbidExitExpressionsRule
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function method(): void
    {
        if (someCondition()) {
            exit; // ✗ Error: Exit expressions should not be used.
        }
    }
    
    public function anotherMethod(): void
    {
        if (errorOccurred()) {
            exit(1); // ✗ Error: Exit expressions should not be used.
        }
    }
    
    public function methodWithDie(): void
    {
        die('Fatal error'); // ✗ Error: Exit expressions should not be used.
    }
    
    public function validMethod(): void
    {
        // ✓ Valid - use exceptions instead
        if (errorOccurred()) {
            throw new RuntimeException('An error occurred');
        }
        
        // ✓ Valid - return error status
        return;
    }
}
```

## Important Notes

- This rule reports **all** `exit` and `die` expressions without exception
- Both `exit` and `die` are language constructs that are equivalent in PHP
- Consider using exceptions for error handling instead of terminating execution
- For CLI applications, consider returning exit codes from the main entry point rather than calling `exit()` throughout the code
- This makes code more testable and allows for proper cleanup and error handling
