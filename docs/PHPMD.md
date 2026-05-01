# MeliorStan and PHPMD

MeliorStan was originally inspired by [**PHPMD - PHP Mess Detector**](https://phpmd.org/), but it is not a 1:1 PHPStan port of PHPMD. The two projects have meaningfully diverged, and a growing portion of MeliorStan's rules have no PHPMD equivalent at all.

This document explains the relationship in more detail and points to PHPMD-style rules that are intentionally absent from MeliorStan because PHPStan core already covers them.

## How MeliorStan Differs from PHPMD

- **Modern PHP syntax.** MeliorStan rules are written against current PHP language features. Many of them analyze syntax that PHPMD's equivalents do not — `match` expressions, enums, readonly properties, first-class callable syntax, and other PHP 8.x constructs.
- **Different and expanded configuration.** Rules that share a name with a PHPMD rule generally accept different (and often more) configuration options. Defaults occasionally differ as well, where a different default produced clearer signal in practice.
- **Rules with no PHPMD counterpart.** A meaningful share of MeliorStan rules — for example `ForbidPestPhpOnly`, `MissingImport`, `MissingClosureParameterTypehint`, `IfStatementAssignment`, `Superglobals`, `CognitiveComplexity`, `BooleanGetMethodName`, and others — exist purely as MeliorStan additions. New rules in this category are added regularly.
- **PHPStan-native architecture.** Each rule is a standalone PHPStan `Rule<NodeType>` with its own configuration. You enable each rule individually in your `phpstan.neon`. MeliorStan does not register rules for you and does not ship rule sets, which differs from PHPMD's bundled rulesets.

## Already Covered by PHPStan

Some PHPMD rules are intentionally not reimplemented in MeliorStan because PHPStan core already provides equivalent (or better) detection out of the box. Rather than ship a redundant copy, we have documented how to enable and configure the PHPStan-native version. The linked pages explain the setup and call out where PHPStan's behavior differs from PHPMD's.

| PHPMD Rule | PHPStan Equivalent | Enable At |
|------------|--------------------|-----------|
| **[DuplicatedArrayKey](DuplicatedArrayKey.md)** | `PHPStan\Rules\Arrays\DuplicateKeysInLiteralArraysRule` | Level 0 (default) |
| **[UnusedPrivateMethod](UnusedPrivateMethod.md)** | `PHPStan\Rules\DeadCode\UnusedPrivateMethodRule` | Rule level 4 |
| **[UnusedPrivateField](UnusedPrivateField.md)** | `PHPStan\Rules\DeadCode\UnusedPrivatePropertyRule` | Rule level 4 |
| **[UndefinedVariable](UndefinedVariable.md)** | `PHPStan\Rules\Variables\DefinedVariableRule` | Level 0 (always undefined) / Level 1 (possibly undefined) |
