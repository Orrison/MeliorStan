# ExcessiveClassLength

This rule detects classes, interfaces, traits, and enums whose line count exceeds a configurable threshold. Excessively long class-like types are a common sign of the "God class" anti-pattern — a single type that does too much and should be split into smaller, focused units.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `1000`
- **Description**: The maximum number of lines a class, interface, trait, or enum may have before the rule reports an error. Lines are counted from the first line of the declaration through the closing brace, inclusive.

### `ignore_whitespace`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When `true`, blank lines and comment-only lines (single-line `//`, `#`, and docblock/`/* */` lines) are excluded from the line count. Useful for codebases that prefer the "effective lines of code" metric over raw line totals.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regular expression pattern (without delimiters) matched against the class, interface, trait, or enum name. When a name matches, the declaration is skipped. Useful for legitimately large types that cannot easily be split, such as generated code or legacy God classes being incrementally refactored. Set to an empty string to apply the rule to all names. Anonymous classes have no name and are never flagged by this rule.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ExcessiveClassLength\ExcessiveClassLengthRule

parameters:
    meliorstan:
        excessive_class_length:
            maximum: 1000
            ignore_whitespace: false
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

class OrderService
{
    // ... 1100 lines of methods, properties, constants, and nested logic ...
}
// ✗ Error: Class "OrderService" has 1100 lines, which exceeds the maximum of 1000. Consider refactoring.

interface LargeContract
{
    // ... 1050 lines of method signatures ...
}
// ✗ Error: Interface "LargeContract" has 1050 lines, which exceeds the maximum of 1000. Consider refactoring.

class SmallService
{
    // ... 200 lines ...
}
// ✓ Valid - within the 1000-line limit
```

### Configuration Examples

#### Custom Maximum

```neon
parameters:
    meliorstan:
        excessive_class_length:
            maximum: 300
```

```php
<?php

class UserRepository
{
    // ... 350 lines ...
}
// ✗ Error: Class "UserRepository" has 350 lines, which exceeds the maximum of 300. Consider refactoring.
```

#### Ignore Whitespace and Comments

```neon
parameters:
    meliorstan:
        excessive_class_length:
            ignore_whitespace: true
```

```php
<?php

class WellDocumentedService
{
    /**
     * Lots of PHPDoc blocks and blank lines between methods,
     * but only ~800 lines of actual code.
     */

    // ... many blank lines and comments, but fewer effective lines ...
}
// ✓ Now valid - blanks and comment-only lines no longer count toward the threshold
```

#### Ignore Pattern (Laravel-friendly)

```neon
parameters:
    meliorstan:
        excessive_class_length:
            ignore_pattern: '^(Legacy|Generated|.*Migration)$'
```

```php
<?php

class LegacyOrderProcessor
{
    // ... 2000 lines of legacy code being incrementally refactored ...
}
// ✓ Now valid - "LegacyOrderProcessor" matches the ignore pattern

class OrderService
{
    // ... 1100 lines ...
}
// ✗ Error: Class "OrderService" has 1100 lines, which exceeds the maximum of 1000. Consider refactoring.
```

## Important Notes

- The rule applies to named classes, interfaces, traits, and enums. Anonymous classes (`new class { ... }`) are always skipped.
- Line counting uses `getStartLine()` and `getEndLine()` on the parser node, so the count includes the declaration line, the opening brace, the body, and the closing brace.
- When `ignore_whitespace` is `true`, the rule reads the source file to classify each line. This is a small per-class cost and only applies when the option is enabled.
- The `ignore_pattern` is case-insensitive and pattern delimiters (`/`) are added automatically — only provide the pattern itself.
