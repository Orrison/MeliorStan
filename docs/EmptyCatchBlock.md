# EmptyCatchBlock

Detects and reports empty catch blocks in exception handling.

Empty catch blocks are problematic because they silently swallow exceptions without any handling, logging, or recovery logic. This can hide errors and make debugging extremely difficult. This rule enforces that all catch blocks contain meaningful error handling code.

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\EmptyCatchBlock\EmptyCatchBlockRule
```

## Examples

### Default Configuration

```php
<?php

use Exception;
use RuntimeException;

class Example
{
    public function method(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // ✗ Error: Empty catch block detected. Catch blocks should contain error handling logic.
        }
    }
    
    public function anotherMethod(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // Just a comment, still considered empty
            // ✗ Error: Empty catch block detected. Catch blocks should contain error handling logic.
        }
    }
    
    public function validMethodWithLogging(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // ✓ Valid - logs the error
            error_log($e->getMessage());
        }
    }
    
    public function validMethodWithRethrow(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // ✓ Valid - wraps and rethrows
            throw new RuntimeException('Operation failed', 0, $e);
        }
    }
    
    public function validMethodWithReturn(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // ✓ Valid - explicit return (graceful degradation)
            return;
        }
    }
    
    public function validMethodWithRecovery(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // ✓ Valid - implements recovery logic
            $this->fallbackOperation();
        }
    }
}
```

## Important Notes

- This rule reports **all** empty catch blocks without exception
- Comments alone do not make a catch block non-empty - actual statements are required
- Empty catch blocks make debugging difficult by hiding errors
- Consider these alternatives to empty catch blocks:
  - **Log the exception**: Use `error_log()`, a logging library, or custom error handler
  - **Rethrow with context**: Wrap the exception in a more specific exception type
  - **Implement recovery logic**: Provide fallback behavior or default values
  - **Return early**: Use explicit `return` statements if the error is expected and can be safely ignored
  - **Set error flags**: Store error state for later handling
- If you genuinely need to ignore an exception (rare cases), document why with a clear comment and include at least a minimal statement (e.g., explicit `return` or no-op assignment)
