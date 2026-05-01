# UnusedPrivateMethod

Detects private methods that are declared on a class but never called from within that class.

> **Status: Already provided by PHPStan core — no MeliorStan rule needed.**
>
> PHPStan ships `PHPStan\Rules\DeadCode\UnusedPrivateMethodRule` out of the box. Because PHPStan's implementation is well-maintained, integrates with the rest of its type system, and is extensible by framework packages, MeliorStan intentionally does **not** reimplement this rule.

## How to enable

The rule is registered automatically once your PHPStan rule level is **4 or higher**. In your `phpstan.neon`:

```neon
parameters:
    level: 4
```

No additional MeliorStan configuration is needed — there is no `Orrison\MeliorStan\Rules\UnusedPrivateMethod\...` rule to register.

## What it detects

- Private instance methods that are never called from inside the declaring class.
- Private static methods that are never called from inside the declaring class.

PHPStan recognizes calls made via:
- `$this->methodName()`
- `self::methodName()`
- `static::methodName()`
- `ClassName::methodName()`
- Array callables like `[$this, 'methodName']` or `[self::class, 'methodName']`

## What it ignores

- Constructors (`__construct`).
- The `__clone` magic method.
- Methods declared inside traits (the trait may be used by classes that call the method).
- Methods marked as always-used by an `AlwaysUsedMethodExtensionProvider` extension. Frameworks (e.g. Symfony, Laravel) and library packages (e.g. PHPUnit) commonly ship such extensions so things like event listeners, controller actions, and test methods are not flagged.

## Customizing for frameworks

If a framework method is being incorrectly flagged as unused, the right fix is usually one of:

1. Install the framework's official PHPStan extension package, which typically registers an `AlwaysUsedMethodExtensionProvider` for you.
2. Implement your own `AlwaysUsedMethodExtensionProvider` — see [PHPStan's developing extensions documentation](https://phpstan.org/developing-extensions/always-used-class-methods).

## How PHPStan compares

PHPStan's behavior is very close to PHPMD's `UnusedPrivateMethod`, with a few intentional differences:

- PHPStan does **not** automatically skip methods whose name matches the class name. (Modern PHP code uses `__construct`, so this PHPMD-era exclusion is rarely useful.)
- PHPStan integrates with framework extensions to suppress false positives, where PHPMD relies on `@SuppressWarnings` annotations.
- PHPStan handles array-callable forms (`[$this, 'foo']`) more thoroughly than PHPMD.

## Bonus: unused private constants

PHPStan also ships `UnusedPrivateConstantRule` at level 4, which detects unused private class constants in the same spirit. No extra configuration required.
