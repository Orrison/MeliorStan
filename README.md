<div align="center">

# MeliorStan 🛡️

**Advanced PHPStan Rules for Superior Code Quality**

*Enhance your PHP codebase with intelligent static analysis rules that detect code smells, enforce naming conventions, and promote best practices.*

[![Latest Stable Version](https://poser.pugx.org/orrison/meliorstan/v/stable)](https://packagist.org/packages/orrison/meliorstan)
[![Total Downloads](https://poser.pugx.org/orrison/meliorstan/downloads)](https://packagist.org/packages/orrison/meliorstan/stats)
[![License](https://poser.pugx.org/Orrison/MeliorStan/license)](https://choosealicense.com/licenses/mit/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-2.1+-orange.svg)](https://phpstan.org/)

</div>

---

## 📋 Table of Contents

- [✨ Features](#-features)
- [🚀 Quick Start](#-quick-start)
- [📚 Available Rules](#-available-rules)
- [🔧 Configuration](#-configuration)
- [🎯 Inspiration](#-inspiration)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)
- [🙏 Acknowledgments](#-acknowledgments)

## ✨ Features

- **🔍 Comprehensive Code Analysis**: Detect code smells and potential issues
- **📏 Naming Convention Enforcement**: Ensure consistent naming across your codebase
- **⚙️ Highly Configurable**: Customize rules to match your project's standards
- **🚀 Modern PHP Support**: Built for PHP 8.3+ with PHPStan 2.1+
- **📖 Extensive Documentation**: Detailed guides for each rule
- **🧪 Well Tested**: Comprehensive test suite ensuring reliability

## 🚀 Quick Start

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

## 📚 Available Rules

### Naming Conventions

| Rule | Description | Target |
|------|-------------|---------|
| **[BooleanGetMethodName](docs/BooleanGetMethodName.md)** | Prevents `get*` methods from returning boolean values | Methods |
| **[CamelCase Method Name](docs/CamelCaseMethodName.md)** | Enforces camelCase for method names | Methods |
| **[CamelCase Parameter Name](docs/CamelCaseParameterName.md)** | Enforces camelCase for parameter names | Parameters |
| **[CamelCase Property Name](docs/CamelCasePropertyName.md)** | Enforces camelCase for property names | Properties |
| **[CamelCase Variable Name](docs/CamelCaseVariableName.md)** | Enforces camelCase for variable names | Variables |
| **[ConstantNamingConventions](docs/ConstantNamingConventions.md)** | Enforces UPPERCASE for constants | Constants |
| **[LongClassName](docs/LongClassName.md)** | Limits class/interface/trait/enum name length | Classes, Interfaces, Traits, Enums |
| **[PascalCase Class Name](docs/PascalCaseClassName.md)** | Enforces PascalCase for class names | Classes |
| **[ShortClassName](docs/ShortClassName.md)** | Enforces minimum class/interface/trait/enum name length | Classes, Interfaces, Traits, Enums |
| **[TraitConstantNamingConventions](docs/TraitConstantNamingConventions.md)** | Enforces UPPERCASE for trait constants | Trait Constants |

### Code Quality

| Rule | Description | Target |
|------|-------------|---------|
| **[MissingClosureParameterTypehint](docs/MissingClosureParameterTypehint.md)** | Requires type hints on closure parameters | Closures |
| **[ShortMethodName](docs/ShortMethodName.md)** | Enforces minimum method name length | Methods |
| **[ShortVariable](docs/ShortVariable.md)** | Enforces minimum variable name length | Variables |
| **[Superglobals](docs/Superglobals.md)** | Discourages use of PHP superglobals | Superglobal Usage |

### Control Flow

| Rule | Description | Target |
|------|-------------|---------|
| **[ElseExpression](docs/ElseExpression.md)** | Discourages `else` expressions | Control Flow |

## 🔧 Configuration

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

## 🎯 Inspiration

Originally inspired by [**PHPMD - PHP Mess Detector**](https://phpmd.org/), this project provides modern PHPStan equivalents with enhanced configurability and PHP 8+ features.

> **Note**: While inspired by PHPMD, these rules are not exact replicas. They offer additional customization options and are adapted for PHPStan's architecture and modern PHP practices.

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup

```bash
git clone https://github.com/Orrison/MeliorStan.git
cd MeliorStan
composer install
composer test
```

### Adding New Rules

1. Follow the established architecture pattern
2. Include comprehensive tests
3. Update documentation
4. Ensure all checks pass: `composer format && composer analyze && composer test`

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [**PHPStan**](https://phpstan.org/) - The foundation of modern PHP static analysis
- [**PHPMD**](https://phpmd.org/) - Original inspiration for code quality rules
- [**PHP-Parser**](https://github.com/nikic/PHP-Parser) - AST parsing capabilities
- **PHP Community** - For continuous improvement of PHP tooling

---

<div align="center">

**Made with ❤️ for the PHP community**

[📖 Documentation](docs/) • [🐛 Report Issues](https://github.com/orrison/meliorstan/issues) • [💡 Request Features](https://github.com/orrison/meliorstan/discussions)

</div>
