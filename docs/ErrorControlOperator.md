# ErrorControlOperator

Detects use of the error control operator (`@`) in PHP code.

The `@` operator suppresses error messages from the expression it precedes. While PHP supports this operator, its use is considered a code smell because it silently hides errors rather than addressing them. Suppressed errors can mask bugs, make debugging difficult, and prevent proper error logging. The correct approach is to validate inputs, check return values, or use exception handling.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\ErrorControlOperator\ErrorControlOperatorRule
```

## Examples

### Default Configuration

```php
<?php

class Example
{
    public function deleteFile(string $path): void
    {
        @unlink($path); // ✗ Error: Use of the error control operator (@) is not allowed.
    }

    public function openFile(string $path): mixed
    {
        return @fopen($path, 'r'); // ✗ Error: Use of the error control operator (@) is not allowed.
    }

    public function getArrayValue(array $data): mixed
    {
        return @$data['missing_key']; // ✗ Error: Use of the error control operator (@) is not allowed.
    }

    public function deleteFileProperly(string $path): void
    {
        // ✓ Valid - check before acting
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function openFileProperly(string $path): mixed
    {
        // ✓ Valid - check the return value explicitly
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return null;
        }

        return $handle;
    }

    public function getArrayValueProperly(array $data): mixed
    {
        // ✓ Valid - use null coalescing
        return $data['missing_key'] ?? null;
    }

    public function riskyOperationProperly(): void
    {
        // ✓ Valid - use exception handling
        try {
            $this->riskyOperation();
        } catch (\Throwable $e) {
            // Handle or log the exception
        }
    }
}
```

## Important Notes

- This rule reports **all** uses of the `@` operator without exception
- The `@` operator works on any expression, including function calls, variable accesses, array accesses, property accesses, and method calls — all are flagged
- Consider using proper alternatives: input validation, return value checks, null coalescing (`??`), or `try`/`catch` blocks
