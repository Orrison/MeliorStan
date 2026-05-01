# IfStatementAssignment

Detects assignments inside `if` and `elseif` conditions.

Assignments in if conditions are a code smell. They can easily mask logic errors, particularly typos where `=` was written instead of `==` or `===`. Additionally, when the assigned value is falsy (e.g., `0`, `null`, `false`, or an empty string), the condition will silently always evaluate to false, leading to bugs that can be difficult to spot. All assignment forms are flagged: plain assignment (`=`), reference assignment (`=&`), and compound assignments (`+=`, `??=`, `.=`, etc.).

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\IfStatementAssignment\IfStatementAssignmentRule
```

## Examples

### Default Configuration

```php
<?php

// ✗ Error: Avoid assignments inside if and elseif conditions.
if ($foo = someFunction()) {
    // ...
}

// ✗ Error: Avoid assignments inside if and elseif conditions.
if ($bar = 0) {
    // ...
}

// ✗ Error: Avoid assignments inside if and elseif conditions.
if ($ref = &$source) {
    // ...
}

// ✗ Error: Avoid assignments inside if and elseif conditions.
if ($count += 1) {
    // ...
}

// ✗ Error: Avoid assignments inside if and elseif conditions.
if (($baz = someFunction()) && $other) {
    // ...
}

// ✗ Error: Avoid assignments inside if and elseif conditions.
if ($x > 1) {
    // ...
} elseif ($result = otherFunction()) {
    // ...
}

// ✓ Valid: assign before the condition
$foo = someFunction();
if ($foo) {
    // ...
}

// ✓ Valid: comparisons are allowed
if ($value === null) {
    // ...
}

// ✓ Valid: compound conditions without assignments
if ($a && $b) {
    // ...
}
```

## Important Notes

- All assignment forms are detected: plain `=`, reference `=&`, and compound operators (`+=`, `??=`, `.=`, etc.).
- Assignments are detected **recursively** throughout the condition expression, including those nested inside compound conditions with `&&`, `||`, and parentheses.
- Both `if` and `elseif` conditions are checked.
- `while` loop conditions are not checked by this rule.
- To use the result of a function call as both an assigned value and a condition, assign it on a separate line before the `if` statement.
