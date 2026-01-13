# Contributing to MeliorStan

Thank you for your interest in contributing to MeliorStan! This document provides guidelines and instructions for contributing to the project.

## 📋 Table of Contents

- [Development Setup](#development-setup)
- [Project Architecture](#project-architecture)
- [Adding New Rules](#adding-new-rules)
- [Testing](#testing)

## Development Setup

### Prerequisites

- PHP 8.3 or higher
- Composer

### Installation

```bash
git clone https://github.com/Orrison/MeliorStan.git
cd MeliorStan
composer install
```

### Available Commands

| Command | Description |
|---------|-------------|
| `composer test` | Run all tests with paratest |
| `composer format` | Auto-fix code style with PHP-CS-Fixer |
| `composer analyze` | Run PHPStan analysis |

## Project Architecture

Each rule typically follows a consistent component structure as follows:

```
src/Rules/{RuleName}/
├── {RuleName}Rule.php    # Main rule implementing Rule<NodeType>
├── Config.php            # Configuration class (if rule has options)

tests/Rules/{RuleName}/
├── config/
│   ├── default.neon      # Default configuration test
│   └── {option}.neon     # Per-option configuration tests
├── Fixture/
│   └── ExampleClass.php  # Test fixtures
├── DefaultTest.php       # Default configuration test
└── {Option}Test.php      # Per-option tests
```

### Key Files

| File | Purpose |
|------|---------|
| `config/extension.neon` | Central dependency injection & parameter schema definition |
| `tests/Rules/*/config/*.neon` | Per-test configuration files that override defaults |
| `tests/Rules/*/Fixture/*.php` | Test fixtures with various code patterns |

## Adding New Rules

1. Follow the established architecture pattern
2. Include comprehensive tests
3. Update documentation
4. Ensure all checks pass: `composer format && composer analyze && composer test`

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run specific rule tests
./vendor/bin/phpunit tests/Rules/{RuleName}/

# Run a single test file
./vendor/bin/phpunit tests/Rules/{RuleName}/DefaultTest.php
```

### Test Conventions

- Each rule has multiple test classes covering all configuration combinations
- Tests use exact line numbers from fixture files
- **Always use error message constants** in test assertions, never hardcoded strings

```php
// ✓ Correct - using constants
$this->analyse([__DIR__ . '/Fixture/Example.php'], [
    [MyRule::ERROR_MESSAGE, 14],
    [sprintf(MyRule::ERROR_MESSAGE_TEMPLATE, 'value', 3), 20],
]);

// ✗ Wrong - hardcoded strings
$this->analyse([__DIR__ . '/Fixture/Example.php'], [
    ['Some hardcoded error message.', 14],
]);
```

## Questions?

If you have questions or need help, please [open an issue](https://github.com/orrison/meliorstan/issues).

---

Thank you for contributing to MeliorStan! 🎉
