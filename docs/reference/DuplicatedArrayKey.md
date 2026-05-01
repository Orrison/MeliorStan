# DuplicatedArrayKey

Detects duplicate keys in PHP array literals, where a later key/value pair silently overwrites an earlier one.

> **Status: Already provided by PHPStan core. No MeliorStan rule needed.**
>
> PHPStan ships `PHPStan\Rules\Arrays\DuplicateKeysInLiteralArraysRule` out of the box. Because PHPStan's implementation is well-maintained, integrates with the rest of its type system, and is enabled at every rule level, MeliorStan intentionally does **not** reimplement this rule.

## How to enable

The rule is active at **level 0** (PHPStan's minimum), so it is enabled in every project that runs PHPStan at any rule level. No additional configuration is needed.

```neon
parameters:
    level: 0  # or any higher level; DuplicateKeysInLiteralArraysRule is always active
```

No MeliorStan configuration is needed; there is no `Orrison\MeliorStan\Rules\DuplicatedArrayKey\...` rule to register.

If you need to suppress a specific occurrence, use PHPStan's standard ignore mechanism with the `array.duplicateKey` identifier:

```neon
parameters:
    ignoreErrors:
        - identifier: array.duplicateKey
```

## What it detects

Duplicate scalar keys in PHP array literals, including:

- Duplicate string keys: `['key' => 1, 'key' => 2]`
- Duplicate integer keys: `[0 => 'a', 0 => 'b']`
- Duplicate boolean keys: `[true => 'a', true => 'b']` (PHP coerces `true` to `1`)
- Duplicate null keys: `[null => 'a', null => 'b']` (PHP coerces `null` to `''`)
- Duplicate implicit numeric keys mixed with explicit ones: `[0 => 'a', 'b', 'c']` where `'b'` is auto-indexed to `0`

PHPStan reports the key value, how many times it appears, and all duplicate instances.

## What it ignores

- Dynamic keys (variables, function calls, constants, and class property accesses) cannot be resolved statically, so PHPStan skips them rather than guess. This matches PHPMD's identical limitation.

```php
$key = 'foo';
$array = [$key => 1, $key => 2];  // Not flagged (key is dynamic)
```

## How PHPStan compares

PHPStan's behavior is equivalent to PHPMD's `DuplicatedArrayKey`, with a few improvements:

- PHPStan reports the **number of duplicates** and all offending line ranges, not just the first occurrence.
- PHPStan handles union types and auto-indexed keys more thoroughly than PHPMD's AST traversal approach.
- PHPStan is enabled at level 0, so it requires zero additional configuration compared to enabling PHPMD separately.
