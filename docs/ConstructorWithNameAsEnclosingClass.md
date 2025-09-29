# ConstructorWithNameAsEnclosingClass

Detects methods that have the same name as their enclosing class, which creates confusion as it resembles a PHP4-style constructor.

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ConstructorWithNameAsEnclosingClass\ConstructorWithNameAsEnclosingClassRule
```

## Examples

```php
<?php

class ExampleClass
{
    public function __construct() {} // ✓ Valid: actual constructor

    public function doSomething() {} // ✓ Valid: different name

    public function ExampleClass() {} // ✗ Error: same name as class
}

class AnotherClass
{
    public function AnotherClass() {} // ✗ Error: same name as class
}
```

## Important Notes

This rule helps maintain code clarity by preventing methods that could be confused with PHP4-style constructors. In modern PHP (8.0+), methods with the same name as their class are treated as regular methods and do not function as constructors. However, they can still create confusion for developers who expect them to be constructors.

The rule automatically excludes:
- The `__construct()` method (the actual constructor)
- Methods in traits and interfaces (which don't have constructors in the traditional sense)