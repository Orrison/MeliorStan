# Messed Up PHPStan - AI Coding Instructions

## Project Overview
This is a PHPStan extension that provides different custom PHPstan rules with configurable options. Each rule has its own namespace under `src/Rules/` and follows a consistent architecture pattern.
Though many of the rules are focused on providing similar functionality to PHP Mess Detector. (https://phpmd.org/) There will also be some rules that are unique to this extension.

## Architecture Pattern
Each rule follows a 3-component structure:
- `{RuleName}Rule.php` - The main rule implementing `Rule<NodeType>`
- `Config.php` - Configuration class with boolean flags for rule options
- Test files in `tests/Rules/{RuleName}/` with multiple configuration scenarios
- Unlike most other PHPStan extensions, this one does not use a single monolithic rule class. Each rule is its own class with its own config. And a User would enable/disable each rule individually in their PHPStan config. We do not register all rules for the user in our extension.neon.

### Key Files
- `config/extension.neon` - Central dependency injection & parameter schema definition
- `tests/Rules/*/config/*.neon` - Per-test configuration files that override defaults
- `tests/Rules/*/Fixture/ExampleClass.php` - Test fixtures with various naming patterns
    - Though this is the primary fixture we have used so far, feel free to add more or different fixture files if needed for specific test cases.

## Critical Development Workflows

### Testing
```bash
composer test              # Run all tests with paratest
./vendor/bin/phpunit tests/Rules/SpecificRule/  # Test specific rule
```

### Code Style
```bash
composer format            # Auto-fix code style with PHP-CS-Fixer
composer analyze           # Run PHPStan analysis
```

## Configuration Architecture
The extension uses Neon dependency injection with a hierarchical configuration system:

1. **Schema Definition** (`config/extension.neon`): Defines parameter structure and defaults
2. **Test Overrides** (`tests/Rules/*/config/*.neon`): Override specific parameters for test scenarios
3. **Service Registration**: Config classes are auto-wired using parameter references

### Critical Pattern: Config Parameter Mapping
In `config/extension.neon`, ensure Config service arguments match the correct parameter namespace:
```neon
- factory: Orrison\MessedUpPhpstan\Rules\CamelCaseParameterName\Config
  arguments:
    - %messed_up.camel_case_parameter_name.allow_consecutive_uppercase%  # Not property_name!
    - %messed_up.camel_case_parameter_name.allow_underscore_prefix%
```

## Rule Implementation Patterns

### Node Type Selection
- **ClassMethod**: Use `ClassMethod::class` for method name rules
- **Property**: Use `Property::class` for property rules (iterate `$node->props`)
- **Param**: Use `Param::class` for parameter rules (check `$node->var->name`)
- **Class_**: Use `Class_::class` for class name rules
- For all other new nodes you can scan `vendor/nikic/php-parser/lib/PhpParser/Node`

### Regex Pattern Building
Rules build patterns dynamically based on config flags, example:
```php
$pattern = '/^';
$pattern .= $this->config->getAllowUnderscorePrefix() ? '_?' : '';
$pattern .= '[a-z]';
$pattern .= $this->config->getAllowConsecutiveUppercase() 
    ? '[a-zA-Z0-9]*' 
    : '(?:[a-z0-9]+|[A-Z][a-z0-9]+)*';
$pattern .= '$/';
```

### Magic Method Exclusion
Method rules exclude PHP magic methods via `$ignoredMethods` array check.

## Test Conventions

### Test Structure
Each rule has multiple test classes covering all possible different configuration combinations, examples are:
- `DefaultOptionsTest` - Default configuration
- `AllowConsecutiveUppercaseTest` - One option enabled
- `AllOptionsTrueTest` - All options enabled
- `Allow{Specific}Test` - Single feature tests

### Test Expectations
Tests use exact line numbers from fixture files. When fixture formatting changes, update expected line numbers in test assertions:
```php
['Parameter name "is_http_response" is not in camelCase.', 5],
```

### Common Test Issues
- **Wrong line numbers**: Update after code formatting changes
- **Wrong error messages**: Ensure "Parameter name" vs "Property name" vs "Method name" matches rule type
- **Config mismatch**: Verify test config file parameters match the rule being tested

## Project-Specific Patterns

### Namespace Convention
All classes use `Orrison\MessedUpPhpstan\` prefix with rule-specific sub-namespaces.

### Error Identifiers
Use consistent identifiers for rule errors:
```php
->identifier('MessedUpPhpstan.methodNameNotCamelCase')
```

### Config Naming
Config methods use descriptive names with `get` prefix and follow camelCase:
- `getAllowConsecutiveUppercase()`
- `getAllowUnderscorePrefix()`
- `getAllowUnderscoreInTests()`

## Common Pitfalls
1. **Config Parameter Mismatch**: Ensure service arguments reference correct parameter namespace in `extension.neon`
2. **Test Line Numbers**: Always verify line numbers match fixture file after formatting
3. **Node Type Confusion**: Use correct node type for the syntax element being validated
4. **Missing Magic Method Exclusion**: Don't forget to exclude PHP magic methods in method rules

## Contribution Guidelines
- Follow the coding standards of the project, styling defined by PHP-CS-Fixer configuration. `php-cs-fixer.php` is the config file. And `composer format` will auto-fix code style. And linting/static analysis can be run with `composer analyze` and is configured with our PHPStan configuration `phpstan.neon.dist`.
- All new rules should follow the established 3-component structure (Rule, Config, Tests) unless there's a compelling reason or asked to deviate.
- When adding new rules, ensure to add appropriate test cases covering all configuration permutations.
- When updating existing rules, ensure backward compatibility unless a breaking change is explicitly intended and documented.
- When done with changes, ensure that you MUST run formatting and static analysis, then run all tests. You must keep doing this till all three pass and it MUST be done in this order as formatting may change line numbers in tests.

## Documentation Standards

### Documentation Requirements
- **MANDATORY**: All rules MUST have comprehensive documentation in `docs/{RuleName}.md`
- **README Updates**: The main `README.md` must be updated to link to new rule documentation
- Documentation must be created/updated whenever:
  - Adding new rules
  - Modifying existing rule behavior
  - Adding or changing configuration options
  - Changing rule names or namespaces

### Documentation Structure
Each rule documentation file must follow this exact structure:

```markdown
# {Rule name without the "Rule" suffix, e.g. CamelCaseVariableName}

{Brief description of what the rule enforces}

{Detailed description explaining the rule's purpose and scope}

## Configuration

This rule supports the following configuration options:

### `config_option_name`
- **Type**: `bool` (or appropriate type)
- **Default**: `false` (or appropriate default)
- **Description**: {Clear description of what this option enables/disables with example}

{If a rule does not have any configurable options, include a note here stating "This rule has no configuration options."}

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/messed-up-phpstan/config/extension.neon

rules:
    - Orrison\MessedUpPhpstan\Rules\{Namespace}\{RuleName}Rule

parameters:
    messed_up:
        {config_namespace}:
            config_option: false
```

## Examples

### Default Configuration

```php
<?php

{Combined valid and invalid examples with comments indicating which are valid/invalid}
```

### Configuration Examples

#### {Config Option Display Name}

```neon
parameters:
    messed_up:
        {config_namespace}:
            config_option: true
```

```php
{Minimal focused examples showing what becomes valid with this configuration}
```

## Important Notes (if applicable)

{Any important behavioral notes, scope limitations, or edge cases}
```

### Documentation Writing Guidelines

1. **Combined Examples**: Use single code blocks with inline comments to show valid (`// ✓ Valid`) and invalid (`// ✗ Error: {message}`) examples
2. **Minimal Configuration Examples**: Each configuration option should have ONE focused example showing its effect
3. **No Redundant Examples**: Avoid multiple examples that demonstrate the same concept with different variable names
4. **Clean Comments**: Use `// ✓ Now valid` (no explanatory notes) for configuration examples
5. **Accurate Examples**: Ensure configuration examples actually require the configuration change (e.g., `httpURL` for consecutive uppercase, not `xmlData`)
6. **Consistent Formatting**: Follow the exact structure and formatting of existing documentation files

### README Integration
When adding new rules, update `README.md` in the Rules section:
```markdown
### [Rule Display Name](docs/{RuleName}.md)

{Brief one-line description matching the rule documentation}
```

### Documentation Validation
Before completing rule implementation:
1. Verify all examples are accurate and require their respective configurations
2. Ensure README.md links are functional and descriptions match
3. Check that configuration parameter names match `extension.neon`
4. Validate that error messages in examples match actual rule output
5. Ensure documentation is done for all possible configurable properties of the rule. If a rule does not have any configurable properties, it must notate that in the documentation like in `Superglobals.md`.