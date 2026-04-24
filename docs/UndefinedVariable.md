# UndefinedVariable

Detects variables that are used before being defined — that is, variables that are read or passed without ever being assigned a value in the current scope.

> **Status: Already provided by PHPStan core — no MeliorStan rule needed.**
>
> PHPStan ships `PHPStan\Rules\Variables\DefinedVariableRule` out of the box. Because PHPStan's implementation is well-maintained, integrates with its full data-flow analysis, and is enabled at every rule level, MeliorStan intentionally does **not** reimplement this PHPMD rule.

## How to enable

The rule is split across two levels:

| Scenario | PHPStan level |
|----------|---------------|
| Variable is **always** undefined (undefined on every code path) | **Level 0** — enabled by default |
| Variable is **possibly** undefined (undefined on some code paths) | **Level 1** or higher |

```neon
parameters:
    level: 1  # or any higher level — catches both always- and possibly-undefined variables
```

No MeliorStan configuration is needed — there is no `Orrison\MeliorStan\Rules\UndefinedVariable\...` rule to register.

To suppress a specific occurrence, use PHPStan's standard ignore mechanism with the `variable.undefined` identifier:

```neon
parameters:
    ignoreErrors:
        - identifier: variable.undefined
```

## What it detects

**Always undefined** (Level 0): a variable that is used and has no possible definition on any branch leading to the usage.

```php
function greet(): string {
    return 'Hello, ' . $name;  // $name is never assigned — always undefined
}
```

**Possibly undefined** (Level 1+): a variable that is defined on some branches but not all.

```php
function process(bool $flag): string {
    if ($flag) {
        $result = 'yes';
    }

    return $result;  // $result is not defined when $flag is false
}
```

## What it ignores

- **Superglobals**: `$_GET`, `$_POST`, `$_SERVER`, `$_SESSION`, `$_COOKIE`, `$_FILES`, `$_ENV`, `$_REQUEST`, and `$GLOBALS` are always considered defined.
- **`$this`**: Automatically recognized as defined inside non-static methods.
- **Reference parameters**: Variables passed by reference (`function foo(&$bar)`) are treated as defined at the call site.

## Laravel / framework note

Laravel helpers like `abort()`, `redirect()->with()`, and similar framework methods terminate execution but PHPStan does not know this by default, which can lead to "possibly undefined" false positives in controller code like:

```php
public function show(int $id): View {
    $user = User::find($id);

    if (! $user) {
        abort(404);
    }

    return view('user.show', ['user' => $user]);
}
```

To teach PHPStan that `abort()` never returns, configure early-terminating calls in your `phpstan.neon`:

```neon
parameters:
    earlyTerminatingFunctionCalls:
        - abort
```

If you use [Laravel's official PHPStan extension](https://github.com/larastan/larastan), this is already configured for you.

## PHPMD parity notes

PHPStan's behavior is a strict superset of PHPMD's `UndefinedVariable`, with several improvements:

- **Control-flow awareness**: PHPMD collects defined variables in a single pass and flags any usage not in that set, which means it misses conditional definitions and produces false positives on variables defined in `if/else` branches. PHPStan's data-flow analysis tracks definitions across every branch.
- **Two-tier reporting**: PHPStan separates "always undefined" (Level 0) from "possibly undefined" (Level 1+), letting you tune sensitivity without ignoring errors entirely.
- **Early-terminating support**: PHPStan can be told which functions/methods never return, preventing false positives that PHPMD cannot avoid without suppression annotations.
- **Zero extra configuration at Level 0**: PHPStan catches the clearest undefined-variable bugs without any additional setup.
