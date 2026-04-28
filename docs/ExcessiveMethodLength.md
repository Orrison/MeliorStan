# ExcessiveMethodLength

This rule detects methods, functions, and closures whose line count exceeds a configurable threshold. Excessively long methods are usually a sign that the code is doing too much and should be broken into smaller, more focused units.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `100`
- **Description**: The maximum number of lines a method, function, or closure may have before the rule reports an error. Lines are counted from the first line of the declaration through the closing brace of the body, inclusive.

### `ignore_whitespace`
- **Type**: `bool`
- **Default**: `false`
- **Description**: When `true`, blank lines and comment-only lines (single-line `//`, `#`, and docblock/`/* */` lines) are excluded from the line count. Useful for codebases that prefer the "effective lines of code" metric over raw line totals.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regular expression pattern (without delimiters) matched against method or function names. When a name matches, the declaration is skipped. Useful for methods that legitimately need to be long, such as Laravel migrations (`up`, `down`), seeders (`run`), service providers (`boot`, `register`), or form request `rules`. Set to an empty string to apply the rule to all names. Closures have no name and are never ignored by this option.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ExcessiveMethodLength\ExcessiveMethodLengthRule

parameters:
    meliorstan:
        excessive_method_length:
            maximum: 100
            ignore_whitespace: false
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

class OrderProcessor
{
    public function processOrder(Order $order): void
    {
        // ... 120 lines of validation, persistence, and side-effects ...
    }
    // ✗ Error: Method "processOrder" has 120 lines, which exceeds the maximum of 100. Consider refactoring.

    public function findById(int $id): ?Order
    {
        return $this->repository->find($id);
    }
    // ✓ Valid - 4 lines
}

function buildReport(array $rows): string
{
    // ... 110 lines ...
}
// ✗ Error: Function "buildReport" has 110 lines, which exceeds the maximum of 100. Consider refactoring.

$callback = function (Request $request) {
    // ... 105 lines ...
};
// ✗ Error: Closure has 105 lines, which exceeds the maximum of 100. Consider refactoring.
```

### Configuration Examples

#### Custom Maximum

```neon
parameters:
    meliorstan:
        excessive_method_length:
            maximum: 30
```

```php
<?php

class Service
{
    public function handle(): void
    {
        // ... 35 lines ...
    }
    // ✗ Error: Method "handle" has 35 lines, which exceeds the maximum of 30.
}
```

#### Ignore Whitespace and Comments

```neon
parameters:
    meliorstan:
        excessive_method_length:
            ignore_whitespace: true
```

```php
<?php

class Calculator
{
    public function compute(): int
    {
        // Step 1: gather inputs
        $a = $this->input();

        // Step 2: validate
        $b = $a * 2;

        // ... lots of comments and blank lines, but only ~80 effective lines ...

        return $b;
    }
    // ✓ Now valid - blanks and comment-only lines no longer count toward the threshold
}
```

#### Ignore Pattern (Laravel-friendly)

```neon
parameters:
    meliorstan:
        excessive_method_length:
            ignore_pattern: '^(boot|register|up|down|run|rules|handle)$'
```

```php
<?php

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        // ... 150 lines of schema definition ...
    }
    // ✓ Now valid - "up" matches the ignore pattern

    public function migrateData(): void
    {
        // ... 120 lines ...
    }
    // ✗ Error: Method "migrateData" has 120 lines, which exceeds the maximum of 100.
}
```

## Important Notes

- The rule applies to class methods, standalone functions, and closures (`function () { ... }`). Arrow functions (`fn () => ...`) are excluded by design because they are syntactically a single expression.
- Methods without a body (abstract method declarations and interface method signatures) are skipped — the rule is concerned with implementation length, not signatures.
- The `ignore_pattern` is case-insensitive and pattern delimiters (`/`) are added automatically — only provide the pattern itself.
- Line counting uses `getStartLine()` and `getEndLine()` on the parser node, so the count includes the signature line, the opening brace, the body, and the closing brace.
- When `ignore_whitespace` is `true`, the rule reads the source file once per candidate node to classify each line. This is a small per-method cost and only applies when the option is enabled.
