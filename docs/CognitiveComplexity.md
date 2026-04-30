# CognitiveComplexity

This rule detects methods with high Cognitive Complexity, a metric that measures how difficult code is to **understand** rather than how difficult it is to test (cyclomatic) or how many paths it has (NPath).

Cognitive Complexity is the SonarSource metric defined by G. Ann Campbell in the 2017 paper *"Cognitive Complexity — A new way of measuring understandability"*. Its headline feature is a **nesting penalty**: a flat sequence of five `if` statements scores far less than five `if` statements nested five levels deep, even though both have identical cyclomatic complexity.

The rule reports both per-method scores and the per-class total (sum of all method scores).

## Configuration

This rule supports the following configuration options:

### `method_maximum`
- **Type**: `int`
- **Default**: `15`
- **Description**: Per-method threshold. Any method with a Cognitive Complexity above this value triggers an error. The default of 15 matches the SonarSource industry recommendation.

### `class_maximum`
- **Type**: `int`
- **Default**: `50`
- **Description**: Per-class threshold. The sum of every method's Cognitive Complexity must not exceed this value. Unlike Cyclomatic Complexity which averages, Cognitive Complexity sums — a class with 50 trivial getters scores ~0, while a class with one tangled method scores high.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regex pattern matched against the method **name** (case-insensitive). Matching methods are skipped — they are neither reported individually nor included in the class total. Example: `^(setUp|tearDown|boot)` skips common lifecycle methods.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\CognitiveComplexity\CognitiveComplexityRule

parameters:
    meliorstan:
        cognitive_complexity:
            method_maximum: 15
            class_maximum: 50
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

class OrderService
{
    // ✓ Valid - score 5 (five sequential ifs, no nesting penalty)
    public function validateFields(Order $order): bool
    {
        if ($order->customerId === null) { return false; }
        if ($order->amount <= 0) { return false; }
        if ($order->currency === '') { return false; }
        if ($order->items === []) { return false; }
        if ($order->shippingAddress === null) { return false; }

        return true;
    }

    // ✗ Error: method process() has a Cognitive Complexity of 21. The allowed threshold is 15.
    // Six-deep nesting: 1 + 2 + 3 + 4 + 5 + 6 = 21
    public function process(Order $order): void
    {
        if ($order->isPaid()) {            // +1 (nesting=0)
            if ($order->isShippable()) {   // +2 (nesting=1)
                foreach ($order->items as $item) {     // +3 (nesting=2)
                    if ($item->inStock()) {            // +4 (nesting=3)
                        while ($item->reserve()) {     // +5 (nesting=4)
                            if ($item->shippable()) {  // +6 (nesting=5)
                                $this->ship($item);
                            }
                        }
                    }
                }
            }
        }
    }
}
```

### Configuration Examples

#### Custom Method Threshold

```neon
parameters:
    meliorstan:
        cognitive_complexity:
            method_maximum: 5
```

```php
// ✗ Error: method process() has a Cognitive Complexity of 15. The allowed threshold is 5.
public function process(int $a, int $b, int $c, int $d, int $e): void
{
    if ($a > 0) {
        if ($b > 0) {
            if ($c > 0) {
                if ($d > 0) {
                    if ($e > 0) {
                        echo 'all';
                    }
                }
            }
        }
    }
}
```

#### Custom Class Threshold

```neon
parameters:
    meliorstan:
        cognitive_complexity:
            class_maximum: 30
```

```php
// ✗ Error: class "WideClass" has a total Cognitive Complexity of 55. The allowed threshold is 30.
class WideClass
{
    // 11 methods, each scoring 5 (five sequential ifs).
    // No single method exceeds method_maximum, but the sum exceeds class_maximum.
}
```

#### Ignore Pattern

```neon
parameters:
    meliorstan:
        cognitive_complexity:
            ignore_pattern: '^(setUp|tearDown|boot|handle)'
```

```php
// ✓ Now valid — name matches ignore_pattern
public function handle(Request $request, Closure $next): Response
{
    // Complex middleware logic with many checks
}
```

## Important Notes

- The rule applies to class methods and standalone functions. Closures and arrow functions are not analyzed as their own units (their bodies still contribute to the enclosing method/function score, with a +1 nesting penalty for the closure boundary).
- Class methods are reported individually (against `method_maximum`) and aggregated for the per-class total (against `class_maximum`). Standalone functions are reported individually only — there is no class to aggregate into.
- **Structural increments** (cost: `1 + currentNesting`): `if`, `else if`, ternary, `for`, `foreach`, `while`, `do-while`, `switch`, `match`, and `catch`. Entering one of these structures increments the nesting level for whatever lives inside.
- **Hybrid increments** (cost: `1`, no nesting bump): `else`.
- **Fundamental increments** (cost: `1` flat):
  - Each *run* of like binary boolean operators in a condition. `a && b && c` adds **+1** (one run); `a && b || c` adds **+2** (two runs); `a && b || c && d` adds **+3**.
  - `goto`, labeled `break`/`continue`, and multi-level `break N` / `continue N` (where N ≥ 2).
  - Direct recursion: a method calling itself (`$this->foo()`, `self::foo()`, `static::foo()`, or — for plain functions — `foo()`) adds **+1** (counted once per method, regardless of how many self-calls are made).
- **Nesting-only** (cost: `0`, but nesting is incremented): `Closure` and `ArrowFunction`. Any control flow inside them is scored at `nesting + 1`.
- **Ignored entirely** (cost: `0`, no nesting bump): null-coalescing operator (`??`), nullsafe (`?->`), null-coalescing assignment (`??=`), and `try`/`finally` block bodies (catches still cost their structural increment).
- **Class total is a sum, not an average.** A class of 20 trivial getters scores ~0; a class with one extremely tangled method scores high. This makes the class threshold meaningful in a way cyclomatic averaging cannot.
- The `ignore_pattern` matches against the method name, not the class name. Ignored methods are excluded from the class total.
- Cognitive Complexity differs from `CyclomaticComplexity` (decision count) and `NpathComplexity` (path count). All three are complementary: cyclomatic measures testability, NPath measures coverage, cognitive measures understandability.
