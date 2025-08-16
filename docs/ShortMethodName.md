# ShortMethodName

This rule enforces that method names must be of a minimum length.

## Configuration

```yaml
parameters:
    meliorstan:
        short_method_name:
            minimum_length: 3
            exceptions: []
```

### Options

- `minimum_length` (int): The minimum length allowed for method names. Default: 3
- `exceptions` (array): List of method names that should be allowed regardless of length. Default: []

## Examples

### ✗ Incorrect

```php
class Example
{
    public function a(): void // Error: 1 character
    {
    }

    public function ab(): void // Error: 2 characters
    {
    }

    public function x(): void // Error: 1 character
    {
    }
}
```

### ✓ Correct

```php
class Example
{
    public function abc(): void // Valid: 3 characters
    {
    }

    public function getName(): void // Valid: 7 characters
    {
    }
}
```

### With Exceptions

```yaml
parameters:
    meliorstan:
        short_method_name:
            minimum_length: 3
            exceptions: ['a', 'is']
```

```php
class Example
{
    public function a(): void // Valid: in exceptions list
    {
    }

    public function is(): void // Valid: in exceptions list
    {
    }

    public function x(): void // Error: 1 character, not in exceptions
    {
    }
}
```
