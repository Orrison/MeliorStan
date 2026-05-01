# NpathComplexity

This rule detects methods and functions with high NPath complexity, which measures the number of acyclic execution paths through the code.

NPath complexity differs fundamentally from cyclomatic complexity: instead of adding one point per decision, it **multiplies** the path count across sequential decision structures. Two independent `if` statements produce an NPath of 4 (2 × 2), not 3 like cyclomatic complexity. This exponential growth makes NPath a sensitive measure of how many distinct paths a test suite must exercise to achieve full coverage.

A method with NPath complexity of 200 has 200 distinct acyclic paths, requiring 200 test cases for full coverage.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `200`
- **Description**: The NPath complexity threshold. Methods and functions with NPath complexity exceeding this value will trigger an error. The default of 200 matches the PHPMD standard.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regex pattern matched against the method or function **name** (case-insensitive). Matching methods and functions are skipped. Useful for excluding known-complex entry points, generated code handlers, or specific lifecycle methods. Example: `^(setUp|tearDown|boot)` skips common Laravel/PHPUnit lifecycle methods.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\NpathComplexity\NpathComplexityRule

parameters:
    meliorstan:
        npath_complexity:
            maximum: 200
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

class OrderService
{
    // ✓ Valid - NPath: 4 (two independent ifs: 2 × 2)
    public function validateOrder(Order $order): bool
    {
        if ($order->isExpired()) {
            return false;
        }

        if ($order->amount <= 0) {
            return false;
        }

        return true;
    }

    // ✗ Error: Method processOrder() has an NPath complexity of 256. The configured maximum is 200.
    // Eight independent if statements: 2^8 = 256 paths
    public function processOrder(Order $order): void
    {
        if ($order->hasDiscount()) { /* ... */ }
        if ($order->isRush()) { /* ... */ }
        if ($order->needsApproval()) { /* ... */ }
        if ($order->isInternational()) { /* ... */ }
        if ($order->hasTax()) { /* ... */ }
        if ($order->isSubscription()) { /* ... */ }
        if ($order->hasGiftCard()) { /* ... */ }
        if ($order->requiresSignature()) { /* ... */ }
    }
}

// ✗ Error: Function importData() has an NPath complexity of 256. The configured maximum is 200.
function importData(array $row): void
{
    if (isset($row['field1'])) { /* ... */ }
    if (isset($row['field2'])) { /* ... */ }
    if (isset($row['field3'])) { /* ... */ }
    if (isset($row['field4'])) { /* ... */ }
    if (isset($row['field5'])) { /* ... */ }
    if (isset($row['field6'])) { /* ... */ }
    if (isset($row['field7'])) { /* ... */ }
    if (isset($row['field8'])) { /* ... */ }
}
```

### Configuration Examples

#### Custom Threshold

```neon
parameters:
    meliorstan:
        npath_complexity:
            maximum: 50
```

```php
// ✗ Error: Method resolve() has an NPath complexity of 64. The configured maximum is 50.
public function resolve(Request $request): Response
{
    if ($request->isGet()) { /* ... */ }
    if ($request->isPost()) { /* ... */ }
    if ($request->isAuthenticated()) { /* ... */ }
    if ($request->hasCsrf()) { /* ... */ }
    if ($request->isJson()) { /* ... */ }
    if ($request->isSecure()) { /* ... */ }
    // NPath = 2^6 = 64
}
```

#### Ignore Pattern

```neon
parameters:
    meliorstan:
        npath_complexity:
            ignore_pattern: '^(setUp|tearDown|boot|handle)'
```

```php
// ✓ Now valid (name matches ignore_pattern)
public function handle(Request $request, Closure $next): Response
{
    // Complex middleware logic with many checks
}
```

## Important Notes

- The rule applies to named class methods and named standalone functions only; anonymous functions (closures) and arrow functions are treated as atomic and do not contribute to the NPath of their containing method
- NPath complexity grows **exponentially** with sequential decision structures: 8 independent `if` statements produce NPath 256 (2^8), while nesting them gives much lower values
- NPath considers: `if`/`elseif`/`else`, `while`, `do-while`, `for`, `foreach`, `switch`/`case`, `try`/`catch`, ternary (`?:`), null coalesce (`??`), logical operators (`&&`, `||`, `and`, `or`), and PHP 8 `match` expressions
- `match` arms are counted similarly to `switch` cases; a `match` without a `default` arm adds one extra path (for the `UnhandledMatchError` case)
- The `ignore_pattern` matches against the method or function name, not the class name
- Consider refactoring by extracting private helper methods, using early returns, or splitting complex methods into smaller, focused units
