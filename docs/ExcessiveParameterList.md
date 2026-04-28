# ExcessiveParameterList

This rule detects functions, methods, closures, and arrow functions whose parameter count exceeds a configurable threshold.

Functions and methods with too many parameters are difficult to call, test, and maintain. A long parameter list is often a sign that related data should be encapsulated into a value object or data transfer object (DTO).

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `10`
- **Description**: The maximum number of parameters a function, method, closure, or arrow function may declare before the rule reports an error.

### `ignore_pattern`
- **Type**: `string`
- **Default**: `''`
- **Description**: A regular expression pattern (without delimiters) matched against method or function names. When a name matches, the declaration is skipped. Useful for methods that legitimately accept many parameters, such as Laravel factory definitions (`definition`) or event listeners. Set to an empty string to apply the rule to all names. Closures and arrow functions have no name and are never ignored by this option.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ExcessiveParameterList\ExcessiveParameterListRule

parameters:
    meliorstan:
        excessive_parameter_list:
            maximum: 10
            ignore_pattern: ''
```

## Examples

### Default Configuration

```php
<?php

class OrderService
{
    public function createOrder(
        int $userId,
        string $sku,
        int $quantity,
        string $currency,
        string $shippingAddress,
        string $billingAddress,
        ?string $couponCode,
        bool $sendConfirmation,
        ?string $notes,
        bool $priority,
        string $channel,
    ): Order {
        // ...
    }
    // ✗ Error: Method "createOrder" has 11 parameters, which exceeds the maximum of 10.
    //   Consider grouping parameters into a value object.

    public function findById(int $id): ?Order
    {
        return $this->repository->find($id);
    }
    // ✓ Valid - 1 parameter

    public function cancel(int $orderId, string $reason): void
    {
        // ...
    }
    // ✓ Valid - 2 parameters
}

function buildReport(
    string $title,
    array $rows,
    string $format,
    bool $includeHeaders,
    bool $includeTotals,
    string $locale,
    string $timezone,
    ?string $footer,
    bool $landscape,
    bool $compress,
    string $encoding,
): string {
    // ...
}
// ✗ Error: Function "buildReport" has 11 parameters, which exceeds the maximum of 10.
//   Consider grouping parameters into a value object.
```

### Configuration Examples

#### Custom Maximum

```neon
parameters:
    meliorstan:
        excessive_parameter_list:
            maximum: 5
```

```php
<?php

class UserService
{
    public function create(
        string $name,
        string $email,
        string $password,
        string $role,
        bool $active,
        string $locale,
    ): User {
        // ...
    }
    // ✗ Error: Method "create" has 6 parameters, which exceeds the maximum of 5.
    //   Consider grouping parameters into a value object.
}
```

#### Ignore Pattern (Laravel-friendly)

```neon
parameters:
    meliorstan:
        excessive_parameter_list:
            ignore_pattern: '^(definition|handle)$'
```

```php
<?php

class UserFactory extends Factory
{
    public function definition(
        string $name,
        string $email,
        string $password,
        string $role,
        bool $active,
        string $locale,
        string $timezone,
        string $locale2,
        string $timezone2,
        bool $verified,
        string $avatar,
    ): array {
        // ...
    }
    // ✓ Now valid - "definition" matches the ignore pattern
}
```

## Important Notes

- The rule applies to class methods (including `__construct` and abstract methods), standalone functions, closures (`function () { ... }`), and arrow functions (`fn () => ...`).
- Interface method signatures are also checked, as the parameter list is part of the contract's design.
- The `ignore_pattern` is case-insensitive and pattern delimiters (`/`) are added automatically — only provide the pattern itself.
- Closures and arrow functions have no name and are never affected by `ignore_pattern`.
