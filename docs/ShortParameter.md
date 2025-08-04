# Short Parameter Rule

Checks that all parameter names are at least a minimum length to improve code readability.

## Configuration

```neon
parameters:
    messed_up:
        short_parameter:
            minimum_length: 3  # Default: 3
            exceptions: []     # Default: empty array
```

### Options

- `minimum_length` (int): The minimum number of characters required for parameter names.
- `exceptions` (string[]): Array of parameter names that are exempt from this rule.

## Examples

### ❌ Invalid (with default settings)

```php
function example($a, $x, $id) {
    return $a + $x + $id;
}
```

### ✅ Valid

```php
function example($amount, $value, $identifier) {
    return $amount + $value + $identifier;
}
```

### ✅ Valid (with exceptions)

```php
// With configuration: exceptions: ['id', 'x']
function example($amount, $x, $id) {
    return $amount + $x + $id;
}
```

## Related Rules

- [ShortVariable](ShortVariable.md) - Checks variable names
- [ShortProperty](ShortProperty.md) - Checks property names
- [ShortMethodName](ShortMethodName.md) - Checks method names
