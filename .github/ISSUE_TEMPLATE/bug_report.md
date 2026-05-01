---
name: Bug report
about: Report a bug in a MeliorStan rule
title: "[Bug] "
labels: bug
---

## Affected Rule

Which rule (e.g. `CamelCaseMethodName`, `CognitiveComplexity`) is having issues?

## Expected Behavior

What did you expect the rule to do?

## Actual Behavior

What did the rule actually do? Include the error output if applicable.

## Reproduction

Minimal PHP snippet that triggers the issue, plus the relevant `phpstan.neon` configuration:

```php
// minimal example
```

```neon
parameters:
    meliorstan:
        rule_name:
            option: value
```

## Environment

- PHP version:
- PHPStan version:
- MeliorStan version:
- OS:
