# CyclomaticComplexity

This rule checks if methods have high cyclomatic complexity, which indicates code that may be difficult to understand, test, and maintain.

Cyclomatic complexity is determined by the number of decision points in a method plus one for the method entry. Decision points include `if`, `elseif`, `while`, `do`, `for`, `foreach`, `case`, `catch`, ternary operators (`?:`), null coalesce (`??`), and boolean operators (`&&`, `||`, `and`, `or`).

Generally:
- 1-4 is low complexity
- 5-7 indicates moderate complexity
- 8-10 is high complexity
- 11+ is very high complexity

## Configuration

This rule supports the following configuration options:

### `report_level`
- **Type**: `int`
- **Default**: `10`
- **Description**: The cyclomatic complexity threshold. Methods with complexity exceeding this value will trigger an error.

### `show_classes_complexity`
- **Type**: `bool`
- **Default**: `true`
- **Description**: When enabled, reports an error if the average complexity of all methods in a class exceeds the threshold.

### `show_methods_complexity`
- **Type**: `bool`
- **Default**: `true`
- **Description**: When enabled, reports an error for individual methods that exceed the complexity threshold.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\CyclomaticComplexity\CyclomaticComplexityRule

parameters:
    meliorstan:
        cyclomatic_complexity:
            report_level: 10
            show_classes_complexity: true
            show_methods_complexity: true
```

## Examples

### Default Configuration

```php
<?php

class PaymentProcessor
{
    // ✓ Valid - Complexity: 4
    public function processPayment(Payment $payment): bool
    {
        if ($payment->isExpired()) {           // 1
            return false;
        }

        if ($payment->amount <= 0) {           // 2
            return false;
        }

        return $payment->gateway === 'stripe'  // 3
            ? $this->processStripe($payment)
            : $this->processDefault($payment);
    }

    // ✗ Error: The method complexValidation() has a Cyclomatic Complexity of 11. The allowed threshold is 10.
    public function complexValidation(array $data): bool
    {
        if (!isset($data['email'])) {          // 1
            return false;
        } elseif (!isset($data['name'])) {     // 2
            return false;
        }

        if ($data['type'] === 'premium') {     // 3
            if ($data['plan'] === 'yearly') {  // 4
                return true;
            } elseif ($data['plan'] === 'monthly') { // 5
                return true;
            }
        } elseif ($data['type'] === 'basic') { // 6
            return true;
        }

        foreach ($data['items'] as $item) {    // 7
            if ($item['valid'] ?? false) {     // 8 (if), 9 (??)
                continue;
            }
        }

        return $data['confirmed'] && $data['verified']; // 10 (&&)
    }
}
```

### Configuration Examples

#### Custom Threshold

```neon
parameters:
    meliorstan:
        cyclomatic_complexity:
            report_level: 5
```

```php
<?php

class UserService
{
    // ✗ Error: Complexity 6 exceeds threshold of 5
    public function validateUser(User $user): bool
    {
        if (!$user->isActive()) {          // 1
            return false;
        }

        if ($user->role === 'admin') {     // 2
            return true;
        } elseif ($user->role === 'mod') { // 3
            return $user->verified;
        }

        return $user->email && $user->verified; // 4 (&&)
    }
}
```

#### Methods Only (Disable Class Average)

```neon
parameters:
    meliorstan:
        cyclomatic_complexity:
            show_classes_complexity: false
```

```php
<?php

class ComplexService
{
    // ✗ Error: Individual method still reported
    public function complexMethod(): void { /* complexity 11 */ }

    // ✓ No class average error even if average exceeds threshold
}
```

#### Classes Only (Disable Individual Methods)

```neon
parameters:
    meliorstan:
        cyclomatic_complexity:
            show_methods_complexity: false
```

```php
<?php

class HighAverageComplexity
{
    public function methodA(): void { /* complexity 12 */ }  // ✓ Not reported individually
    public function methodB(): void { /* complexity 12 */ }  // ✓ Not reported individually

    // ✗ Error: Class average of 12.00 exceeds threshold
}
```

## Important Notes

- The rule applies to classes, interfaces, traits, and enums
- Each `case` in a switch statement adds 1 to complexity (except `default`)
- Both short-circuit operators (`&&`, `||`) and textual operators (`and`, `or`) are counted
- The null coalesce operator (`??`) counts as a decision point
- Ternary expressions (`?:`) count as a decision point
- Class average is calculated as: total complexity of all methods / number of methods
- Consider refactoring high-complexity methods by extracting smaller, focused methods
