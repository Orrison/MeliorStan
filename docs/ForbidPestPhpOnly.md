# ForbidPestPhpOnly

Detects and reports usage of Pest's `only()` filter in test suites.

Pest's `only()` filter is a powerful local debugging aid that focuses a run on a single test, but it should never be committed to source control. Leaving `->only()` in the codebase causes large parts of the test suite to be skipped in CI, hiding regressions until much later. This rule keeps committed test code safe by flagging any `->only()` chains inside test files.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ForbidPestPhpOnly\ForbidPestPhpOnlyRule
```

## Examples

### Default Configuration

```php
<?php

// ✗ Error: Pest's only() filter should not be used in committed tests.
test('math still works', function () {
    expect(1 + 1)->toBe(2);
})->only();

it('handles completely different behaviour', function () {
    expect(true)->toBeTrue();
}); // ✓ Valid

uses()->group('integration'); // ✓ Valid
```

## Important Notes

- The rule considers a file to be a test when it resides inside a `tests/` directory, ends with `Test.php`, or is named `Pest.php`
- Only `->only()` calls chained from Pest's `test()` or `it()` helpers are reported; other methods named `only` are ignored
- `only()` is meant for temporary local debugging; remove the call before committing
- Pest also provides other granular filters (`--filter`, `--group`, datasets). Prefer those when you need persistent targeting without modifying source files
