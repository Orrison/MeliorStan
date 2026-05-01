<div align="center">

# MeliorStan

**Advanced PHPStan Rules for Code Quality and Consistency**

*Enhance your PHP codebase with intelligent static analysis rules that detect code smells, enforce naming conventions, and promote best practices.*

[![Latest Stable Version](https://poser.pugx.org/orrison/meliorstan/v/stable)](https://packagist.org/packages/orrison/meliorstan)
[![Total Downloads](https://poser.pugx.org/orrison/meliorstan/downloads)](https://packagist.org/packages/orrison/meliorstan/stats)
[![License](https://poser.pugx.org/Orrison/MeliorStan/license)](https://choosealicense.com/licenses/mit/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-2.1+-orange.svg)](https://phpstan.org/)

</div>

---

## Table of Contents

- [Features](#-features)
- [Quick Start](#-quick-start)
- [Available Rules](#-available-rules)
- [Configuration](#-configuration)
- [License](#-license)
- [Acknowledgments](#-acknowledgments)

## Features

- **Comprehensive Code Analysis**: Detect code smells and potential issues
- **Naming Convention Enforcement**: Ensure consistent naming across your codebase
- **Highly Configurable**: Customize rules to match your project's standards
- **Modern PHP Support**: Built for PHP 8.3+ with PHPStan 2.1+
- **Extensive Documentation**: Detailed guides for each rule
- **Well Tested**: Comprehensive test suite ensuring reliability

## Quick Start

### Installation

```bash
composer require --dev orrison/meliorstan
```

### Basic Usage

Add to your `phpstan.neon` configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\PascalCaseClassName\PascalCaseClassNameRule
    - Orrison\MeliorStan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule
```

### Configuration

Customize rule behavior in your `phpstan.neon`:

```neon
parameters:
    meliorstan:
        pascal_case_class_name:
            allow_consecutive_uppercase: false
        camel_case_method_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
```

## Available Rules

### Naming Conventions

| Rule | Description | Target |
|------|-------------|---------|
| **[BooleanGetMethodName](docs/BooleanGetMethodName.md)** | Prevents `get*` methods from returning boolean values | Methods |
| **[CamelCaseMethodName](docs/CamelCaseMethodName.md)** | Enforces camelCase for method names | Methods |
| **[CamelCaseParameterName](docs/CamelCaseParameterName.md)** | Enforces camelCase for parameter names | Parameters |
| **[CamelCasePropertyName](docs/CamelCasePropertyName.md)** | Enforces camelCase for property names | Properties |
| **[CamelCaseVariableName](docs/CamelCaseVariableName.md)** | Enforces camelCase for variable names | Variables |
| **[ConstantNamingConventions](docs/ConstantNamingConventions.md)** | Enforces UPPERCASE for constants | Constants |
| **[ConstructorWithNameAsEnclosingClass](docs/ConstructorWithNameAsEnclosingClass.md)** | Prevents methods with same name as their class | Methods |
| **[LongClassName](docs/LongClassName.md)** | Limits class/interface/trait/enum name length | Classes, Interfaces, Traits, Enums |
| **[PascalCase Class Name](docs/PascalCaseClassName.md)** | Enforces PascalCase for class names | Classes |
| **[ShortClassName](docs/ShortClassName.md)** | Enforces minimum class/interface/trait/enum name length | Classes, Interfaces, Traits, Enums |
| **[TraitConstantNamingConventions](docs/TraitConstantNamingConventions.md)** | Enforces UPPERCASE for trait constants | Trait Constants |

### Code Quality

| Rule | Description | Target |
|------|-------------|---------|
| **[BooleanArgumentFlag](docs/BooleanArgumentFlag.md)** | Detects boolean parameters in functions and methods that may indicate multiple responsibilities | Methods, Functions, Closures |
| **[LongVariable](docs/LongVariable.md)** | Limits variable name length | Variables |
| **[MissingClosureParameterTypehint](docs/MissingClosureParameterTypehint.md)** | Requires type hints on closure parameters | Closures |
| **[MissingImport](docs/MissingImport.md)** | Detects types referenced by fully qualified name instead of being imported with a `use` statement | Type-reference positions |
| **[ShortMethodName](docs/ShortMethodName.md)** | Enforces minimum method name length | Methods |
| **[ShortVariable](docs/ShortVariable.md)** | Enforces minimum variable name length | Variables |
| **[ForbidPestPhpOnly](docs/ForbidPestPhpOnly.md)** | Prevents committed Pest tests from using the `only()` filter | Tests |
| **[Superglobals](docs/Superglobals.md)** | Discourages use of PHP superglobals | Superglobal Usage |
| **[UnusedFormalParameter](docs/UnusedFormalParameter.md)** | Detects function/method/closure parameters that are declared but never used | Function/method/closure parameters |
| **[UnusedLocalVariable](docs/UnusedLocalVariable.md)** | Detects local variables assigned but never read inside a function/method/closure | Local Variables |

### Control Flow

| Rule | Description | Target |
|------|-------------|---------|
| **[ElseExpression](docs/ElseExpression.md)** | Discourages `else` expressions | Control Flow |
| **[IfStatementAssignment](docs/IfStatementAssignment.md)** | Detects assignments inside `if` and `elseif` conditions | Control Flow |

### Design

| Rule | Description | Target |
|------|-------------|---------|
| **[DevelopmentCodeFragment](docs/DevelopmentCodeFragment.md)** | Detects calls to development/debug functions like var_dump, print_r, etc. | Function Calls |
| **[EmptyCatchBlock](docs/EmptyCatchBlock.md)** | Detects and reports empty catch blocks in exception handling | Catch Blocks |
| **[ErrorControlOperator](docs/ErrorControlOperator.md)** | Detects use of the error control operator (@), which silently suppresses errors instead of handling them properly | Error Suppression |
| **[ForbidCountInLoopExpressions](docs/ForbidCountInLoopExpressions.md)** | Detects usage of count() or sizeof() in loop conditions | Loop Conditions |
| **[ForbidEvalExpressions](docs/ForbidEvalExpressions.md)** | Detects and reports usage of eval expressions | Eval Expressions |
| **[ForbidExitExpressions](docs/ForbidExitExpressions.md)** | Detects and reports usage of exit and die expressions | Exit Expressions |
| **[ForbidGotoStatements](docs/ForbidGotoStatements.md)** | Detects and reports usage of goto statements | Goto Statements |
| **[CouplingBetweenObjects](docs/CouplingBetweenObjects.md)** | Detects classes with too many type dependencies | Classes, Interfaces, Traits, Enums |
| **[DepthOfInheritance](docs/DepthOfInheritance.md)** | Detects classes with excessively deep inheritance chains | Classes |
| **[ExcessiveClassLength](docs/ExcessiveClassLength.md)** | Detects classes, interfaces, traits, and enums with excessive line counts | Classes, Interfaces, Traits, Enums |
| **[ExcessiveMethodLength](docs/ExcessiveMethodLength.md)** | Detects methods, functions, and closures with excessive line counts | Methods, Functions, Closures |
| **[ExcessiveClassComplexity](docs/ExcessiveClassComplexity.md)** | Detects classes with excessive total cyclomatic complexity (Weighted Method Count) | Classes, Interfaces, Traits, Enums |
| **[ExcessiveParameterList](docs/ExcessiveParameterList.md)** | Detects functions, methods, closures, and arrow functions with too many parameters | Functions, Methods, Closures, Arrow Functions |
| **[ExcessivePublicCount](docs/ExcessivePublicCount.md)** | Detects classes with an excessive public API surface (public methods + properties) | Classes, Interfaces, Traits, Enums |
| **[CyclomaticComplexity](docs/CyclomaticComplexity.md)** | Detects methods, functions, and classes with high cyclomatic complexity | Methods, Functions, Classes |
| **[NpathComplexity](docs/NpathComplexity.md)** | Detects methods and functions with high NPath complexity (number of acyclic execution paths) | Methods, Functions |
| **[CognitiveComplexity](docs/CognitiveComplexity.md)** | Detects methods, functions, and classes with high Cognitive Complexity, the SonarSource understandability metric with a nesting penalty | Methods, Functions, Classes |
| **[NumberOfChildren](docs/NumberOfChildren.md)** | Detects classes with too many direct child classes | Class Hierarchy |
| **[StaticAccess](docs/StaticAccess.md)** | Detects static method calls and optionally static property access that create tight coupling | Static Access |
| **[TooManyFields](docs/TooManyFields.md)** | Detects classes and traits with an excessive number of instance fields | Classes, Traits |
| **[TooManyMethods](docs/TooManyMethods.md)** | Detects classes with too many methods | Classes, Interfaces, Traits, Enums |
| **[TooManyPublicMethods](docs/TooManyPublicMethods.md)** | Detects classes with too many public methods | Classes, Interfaces, Traits, Enums |

## Configuration

Each rule supports extensive configuration options. Refer to individual rule documentation for detailed configuration parameters.

### Global Configuration Structure

```neon
parameters:
    meliorstan:
        rule_name:
            option1: value1
            option2: value2
```

### Example: Comprehensive Setup

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\PascalCaseClassName\PascalCaseClassNameRule
    - Orrison\MeliorStan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule
    - Orrison\MeliorStan\Rules\LongClassName\LongClassNameRule

parameters:
    meliorstan:
        pascal_case_class_name:
            allow_consecutive_uppercase: true
        camel_case_method_name:
            allow_consecutive_uppercase: false
            allow_underscore_prefix: false
        long_class_name:
            maximum: 50
            subtract_prefixes: ["Abstract", "Base"]
            subtract_suffixes: ["Interface", "Trait"]
```

## Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

## License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [**PHPStan**](https://phpstan.org/): the foundation of modern PHP static analysis that MeliorStan builds on.
- [**PHPMD - PHP Mess Detector**](https://phpmd.org/): the original inspiration for many of the code quality rules. MeliorStan is not a direct 1:1 port; overlapping rules have diverged in behavior and configuration. See [MeliorStan and PHPMD](docs/PHPMD.md) for more information.

---

<div align="center">

[Documentation](docs/) • [Report Issues](https://github.com/orrison/meliorstan/issues)

</div>
