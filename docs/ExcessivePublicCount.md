# ExcessivePublicCount

This rule reports classes, interfaces, traits, and enums that expose an excessively large public API surface — the sum of their public methods and public properties.

Based on the [PHPMD ExcessivePublicCount](https://phpmd.org/rules/codesize.html#excessivepubliccount) rule, which measures the PHP_Depend **CIS** (Class Interface Size) metric. A large public surface often signals that a class has too many responsibilities and is difficult to test thoroughly.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `45`
- **Description**: The maximum allowed sum of public methods plus public properties in a class-like structure before triggering an error. Matches PHPMD's default CIS threshold.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `^(get|set|is)`
- **Description**: A regular expression pattern (without delimiters) used to match public method names that should be excluded from the count. By default, getter, setter, and boolean accessor methods are ignored, matching the convention used by the `TooManyMethods` rule. Set to an empty string `''` to count every public method (strict PHPMD parity).

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ExcessivePublicCount\ExcessivePublicCountRule

parameters:
    meliorstan:
        excessive_public_count:
            maximum: 45
            ignore_pattern: '^(get|set|is)'
```

## Examples

### Default Configuration

```php
<?php

class GodClass
{
    public int $propertyOne = 0;
    public int $propertyTwo = 0;
    // ... 24 more public properties (26 total)

    public function doOne(): void {}
    public function doTwo(): void {}
    // ... 18 more public methods (20 total)
}
// ✗ Error: Class "GodClass" has 46 public members (20 methods, 26 properties),
//          which exceeds the maximum of 45. Consider reducing the public API surface.

class DataTransferObject
{
    public function getName(): string { return ''; }
    public function getEmail(): string { return ''; }
    // ... 48 more getters (50 total)
}
// ✓ Valid — all 50 methods match the default ignore_pattern '^(get|set|is)'
//          and are excluded from the count.

class ModestClass
{
    public int $id = 0;
    private int $internalState = 0;          // private — not counted
    protected int $protectedState = 0;       // protected — not counted

    public function process(): void {}
    private function helper(): void {}       // private — not counted
}
// ✓ Valid — only 2 public members; private and protected members are excluded.
```

### Configuration Examples

#### Strict PHPMD Parity (No Ignore Pattern)

```neon
parameters:
    meliorstan:
        excessive_public_count:
            ignore_pattern: ''
```

```php
<?php

class DataTransferObject
{
    public function getOne(): int { return 1; }
    public function getTwo(): int { return 2; }
    // ... 44 more getters (46 total)
}
// ✗ Error: 46 public members exceeds the maximum of 45.
//          With ignore_pattern='' getters are counted verbatim.
```

#### Custom Maximum

```neon
parameters:
    meliorstan:
        excessive_public_count:
            maximum: 10
```

```php
<?php

class Service
{
    public int $a = 0, $b = 0, $c = 0, $d = 0, $e = 0, $f = 0;

    public function doOne(): void {}
    public function doTwo(): void {}
    public function doThree(): void {}
    public function doFour(): void {}
    public function doFive(): void {}
}
// ✗ Error: Class "Service" has 11 public members (5 methods, 6 properties),
//          which exceeds the maximum of 10.
```

## Important Notes

- The rule applies to classes, interfaces, traits, and enums.
- Interface methods are always counted — all interface methods are implicitly public.
- Enum **cases** are not properties and are not counted. Only public methods on enums contribute to the total.
- Compound property declarations count each declared variable separately: `public $a, $b, $c` adds 3 to the property count.
- Private and protected members are never counted.
- The `ignore_pattern` is case-insensitive and pattern delimiters (`/`) are added automatically — only provide the pattern itself.
- A malformed `ignore_pattern` regex throws an `InvalidArgumentException` naming the offending pattern, matching the behavior of `TooManyMethods`.
- Methods and properties are counted only from the class-like's own declaration — inherited members are not included.
