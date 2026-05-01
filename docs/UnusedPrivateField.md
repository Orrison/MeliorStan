# UnusedPrivateField

Detects private properties that are declared on a class but never accessed from within that class.

> **Status: Already provided by PHPStan core — no MeliorStan rule needed.**
>
> PHPStan ships `PHPStan\Rules\DeadCode\UnusedPrivatePropertyRule` out of the box. Its implementation is more granular than PHPMD's `UnusedPrivateField`: it distinguishes between *fully unused*, *write-only*, and *read-only* properties. MeliorStan therefore intentionally does **not** reimplement this rule.

## How to enable

The rule is registered automatically once your PHPStan rule level is **4 or higher**:

```neon
parameters:
    level: 4
```

No additional MeliorStan configuration is needed — there is no `Orrison\MeliorStan\Rules\UnusedPrivateField\...` rule to register.

## What it detects

PHPStan reports three distinct error variants for private properties:

1. **Fully unused** — the property is neither read nor written anywhere in the class.
2. **Never read (write-only)** — the property is assigned but its value is never used. Often a sign of a forgotten getter or genuinely dead state.
3. **Never written (read-only)** — the property is read but never assigned. Often indicates a missing constructor parameter or setter — and may be a real bug.

PHPStan recognizes property access via `$this->property`, `self::$property`, `static::$property`, and `ClassName::$property`.

## Customizing

### Marking properties as always-used via PHPDoc tags

If you use a framework like Doctrine where property assignment happens via reflection (e.g. through `@ORM\Column`), you can configure PHPStan to treat properties annotated with specific PHPDoc tags as always-read or always-written:

```neon
parameters:
    propertyAlwaysReadTags:
        - phpstan-property-always-read
        - ORM\Column
    propertyAlwaysWrittenTags:
        - phpstan-property-always-written
        - ORM\Column
```

### Programmatic extension

For more advanced cases, implement a `PHPStan\Rules\Properties\ReadWritePropertiesExtension`. Most popular framework PHPStan extensions (Doctrine, Symfony, Laravel) already register one for you — installing the official extension package is usually all that's needed.

### Interaction with `checkUninitializedProperties`

If you also enable:

```neon
parameters:
    checkUninitializedProperties: true
```

PHPStan will additionally report typed properties that are never assigned in the constructor. This pairs well with `UnusedPrivatePropertyRule` because together they catch both "never written" (a likely bug) and "never initialized in constructor" (a definite bug).

## How PHPStan compares

PHPStan's behavior is a strict superset of PHPMD's `UnusedPrivateField`:

- PHPMD only reports the *fully unused* case. PHPStan additionally reports the more useful *write-only* and *read-only* variants.
- PHPMD relies on `@SuppressWarnings` annotations; PHPStan uses extensions and PHPDoc tags so framework-managed properties are silenced project-wide instead of per-property.

## Bonus: unused private constants

PHPStan also ships `UnusedPrivateConstantRule` at level 4, which detects unused private class constants. No extra configuration required.
