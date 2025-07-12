# Messed Up PHPStan

Provides custom PHPStan rules for different enforcements throughout your codebase to look for potential probems and enforce particular programatic or naming style.

## Inspiration

Originally inspired by [PHPMD - PHP Mess Detector](https://phpmd.org/), this project attempts to provide equivalent rules with modern interpretation and maintenance.

Note that all rules inspired by PHPMD are simply that, inspired. They are often similiar in their enforcements. But they are not complete 1-to-1 replications, in that they provided different or additional customization via different parameters.

Not every rule in this extention is inspired by PHPMD. Additional rules beyond those that replicate PHPMD enforcements are also provided.

## Rules

### Superglobals Rule

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

#### Configuration

This rule has no configuration options.

#### Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\Superglobals\SuperglobalsRule
```

#### Example

```php
<?php

class BadExample
{
    public function getData()
    {
        // This will trigger a violation
        $data = $_POST['user_input']; // Error: Superglobal "$_POST" should not be used in userland code.
        
        return $data;
    }
}
```
