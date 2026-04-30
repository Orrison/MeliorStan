# ExcessiveClassComplexity

Detects classes with an excessively high **Weighted Method Count (WMC)** — the sum of cyclomatic complexities of all methods in the class.

A high WMC indicates a class that is doing too much. Such classes are harder to understand, test, and maintain, and can amplify problems in subclasses due to the number of inherited decision paths.

Cyclomatic complexity is determined by the number of decision points in a method plus one for the method entry. Decision points include `if`, `elseif`, `while`, `do`, `for`, `foreach`, `case`, `catch`, ternary operators (`?:`), null coalesce (`??`), and boolean operators (`&&`, `||`, `and`, `or`).

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `50`
- **Description**: The maximum allowed Weighted Method Count. Classes whose total cyclomatic complexity across all methods exceeds this value will trigger an error.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regex pattern (case-insensitive) matched against the class name. Classes whose names match are skipped entirely. For example, setting `ignore_pattern: 'Service'` will skip any class whose name contains "Service".

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ExcessiveClassComplexity\ExcessiveClassComplexityRule

parameters:
    meliorstan:
        excessive_class_complexity:
            maximum: 50
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

// ✓ Valid - WMC = 8 (two simple methods, total complexity under 50)
class OrderSummary
{
    public function getTotal(array $items): float
    {
        $total = 0.0;

        foreach ($items as $item) {    // +1
            if ($item['active']) {     // +1
                $total += $item['price'] ?? 0; // +1
            }
        }

        return $total;
    }

    public function getCount(array $items): int
    {
        $count = 0;

        foreach ($items as $item) {    // +1
            if ($item['active']) {     // +1
                $count++;
            }
        }

        return $count;
    }
}

// ✗ Error: Class "OrderProcessor" has a Weighted Method Count of 55. The allowed maximum is 50. Consider distributing complexity among smaller classes.
class OrderProcessor
{
    public function processOrder(int $status): void      // complexity: 11
    { /* many decision points */ }

    public function validatePayment(int $amount): bool   // complexity: 11
    { /* many decision points */ }

    public function calculateTotal(int $qty, int $price): int // complexity: 11
    { /* many decision points */ }

    public function applyDiscount(int $total, int $code): int // complexity: 11
    { /* many decision points */ }

    public function generateReport(int $period, int $type): string // complexity: 11
    { /* many decision points */ }
    // WMC = 55
}
```

### Configuration Examples

#### Lower Threshold

```neon
parameters:
    meliorstan:
        excessive_class_complexity:
            maximum: 20
```

```php
<?php

// ✗ Error: WMC of 22 exceeds threshold of 20
class UserManager
{
    public function create(array $data): bool    // complexity: 6
    { /* ... */ }

    public function update(array $data): bool    // complexity: 6
    { /* ... */ }

    public function delete(int $id): bool        // complexity: 5
    { /* ... */ }

    public function findAll(array $filters): array // complexity: 5
    { /* ... */ }
    // WMC = 22
}
```

#### Ignore Pattern

```neon
parameters:
    meliorstan:
        excessive_class_complexity:
            ignore_pattern: 'LegacyService'
```

```php
<?php

// ✓ Now valid - class name matches the ignore pattern
class LegacyServiceFacade
{
    // ... many complex methods that exceed the threshold
}
```

## Important Notes

- The rule applies to classes, interfaces, traits, and enums
- All methods are included in the WMC calculation, including abstract and magic methods
- The threshold applies to the **total** complexity across all methods, not the average — see `CyclomaticComplexity` for average-based checking
- Consider splitting high-WMC classes into focused, single-responsibility classes
- The `ignore_pattern` is matched case-insensitively against the class name only, not the full namespace

## Related Rules

This suite has three overlapping class-level complexity checks. They are intentionally complementary — each catches a failure mode the others miss. Use whichever signals you actually care about:

| Rule | Class-level metric | Catches | Misses |
|---|---|---|---|
| `ExcessiveClassComplexity` | **Sum** of cyclomatic (Weighted Method Count) | God classes — many methods, or a few very complex ones, or both | Cannot tell breadth from depth |
| [`CyclomaticComplexity`](CyclomaticComplexity.md) (`show_classes_complexity`) | **Average** cyclomatic per method | Classes where every method is dense on average | One bad method drowned by trivial getters (the average dilutes) |
| [`CognitiveComplexity`](CognitiveComplexity.md) (`class_maximum`) | **Sum** of cognitive | Classes that are *hard to understand* — deep nesting, tangled control flow | Wide-but-simple classes (50 trivial getters score ~0) |

WMC is the most informative cyclomatic-based class signal — averages dilute under trivial methods. Pair it with `CognitiveComplexity` to also catch classes that are tangled rather than just large.
