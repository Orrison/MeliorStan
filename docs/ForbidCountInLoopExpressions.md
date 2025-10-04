# ForbidCountInLoopExpressions

Detects usage of `count()` or `sizeof()` functions in loop condition expressions.

Using `count()` or `sizeof()` in loop conditions can cause performance issues or hard to trace bugs. This rule helps identify such cases.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ForbidCountInLoopExpressions\ForbidCountInLoopExpressionsRule
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function validLoopWithCachedCount(): void
    {
        $items = [1, 2, 3];
        $count = count($items); // ✓ Valid - count cached before loop
        
        for ($i = 0; $i < $count; $i++) {
            echo $items[$i];
        }
    }
    
    public function invalidForLoop(): void
    {
        $items = [1, 2, 3];
        
        for ($i = 0; $i < count($items); $i++) { // ✗ Error: Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.
            echo $items[$i];
        }
    }
    
    public function invalidWhileLoop(): void
    {
        $items = [1, 2, 3];
        $i = 0;
        
        while ($i < count($items)) { // ✗ Error: Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.
            echo $items[$i++];
        }
    }
    
    public function invalidDoWhileLoop(): void
    {
        $items = [1, 2, 3];
        $i = 0;
        
        do {
            echo $items[$i++];
        } while ($i < sizeof($items)); // ✗ Error: Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.
    }
    
    public function complexCondition(): void
    {
        $items = [1, 2, 3];
        
        for ($i = 0; $i < count($items) - 1; $i++) { // ✗ Error: Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.
            echo $items[$i];
        }
    }
    
    public function validCountInLoopBody(): void
    {
        $items = [1, 2, 3];
        
        for ($i = 0; $i < 3; $i++) { // ✓ Valid - condition doesn't use count()
            $total = count($items); // ✓ Valid - count in loop body is not checked
            echo $total;
        }
    }
}
```

## Important Notes

- This rule only checks loop **conditions**, not loop bodies
- Both `count()` and `sizeof()` functions are detected
- Applies to `for`, `while`, and `do-while` loops
- Only reports the first occurrence per loop to avoid duplicate errors
- Nested loops are checked independently
- Only checks global `count()` and `sizeof()` functions, not method calls like `$obj->count()`
