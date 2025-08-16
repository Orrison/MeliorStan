# Superglobals

Enforces that PHP superglobals should not be used.

This rule detects usage of the following PHP superglobals:
- `$GLOBALS`
- `$_SERVER`
- `$_GET`
- `$_POST`
- `$_FILES`
- `$_COOKIE`
- `$_SESSION`
- `$_REQUEST`
- `$_ENV`

## Configuration

This rule has no configuration options.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\Superglobals\SuperglobalsRule
```

## Example

```php
<?php

class BadExample
{
    public function getData()
    {
        // This will trigger a violation
        $data = $_POST['user_input']; // Error: Superglobal "$_POST" should not be used.
        
        return $data;
    }
}
```
