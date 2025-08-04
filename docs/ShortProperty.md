# Short Property Rule

Checks that all property names are at least a minimum length to improve code readability.

## Configuration

```neon
parameters:
    messed_up:
        short_property:
            minimum_length: 3  # Default: 3
            exceptions: []     # Default: empty array
```

### Options

- `minimum_length` (int): The minimum number of characters required for property names.
- `exceptions` (string[]): Array of property names that are exempt from this rule.

## Examples

### ❌ Invalid (with default settings)

```php
class Example 
{
    public $x;
    public $id;
    private $a;
}
```

### ✅ Valid

```php
class Example 
{
    public $value;
    public $identifier;
    private $amount;
}
```

### ✅ Valid (with exceptions)

```php
// With configuration: exceptions: ['id', 'x']
class Example 
{
    public $x;
    public $id;
    private $amount;
}
```

## Related Rules

- [ShortVariable](ShortVariable.md) - Checks variable names
- [ShortParameter](ShortParameter.md) - Checks parameter names
- [ShortMethodName](ShortMethodName.md) - Checks method names
