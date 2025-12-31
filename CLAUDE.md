# MeliorStan - AI Coding Instructions

## Project Overview
This is a PHPStan extension that provides different custom PHPstan rules with configurable options. Each rule has its own namespace under `src/Rules/` and follows a consistent architecture pattern.
Though many of the rules are focused on providing similar functionality to PHP Mess Detector. (https://phpmd.org/) There will also be some rules that are unique to this extension.

## Architecture Pattern
Each rule follows a 3-component structure:
- `{RuleName}Rule.php` - The main rule implementing `Rule<NodeType>`
- `Config.php` - Configuration class with boolean flags for rule options. This class is used to define the configuration options for the rule. Not all rules have configuration options, but those that do will have a `Config` class this that do not will not.
- Test files in `tests/Rules/{RuleName}/` with multiple configuration scenarios if applicable.
- Unlike most other PHPStan extensions, this one does not use a single monolithic rule class. Each rule is its own class with its own config. And a User would enable/disable each rule individually in their PHPStan config. We do not register all rules for the user in our extension.neon.

### Key Files
- `config/extension.neon` - Central dependency injection & parameter schema definition
- `tests/Rules/*/config/*.neon` - Per-test configuration files that override defaults
- `tests/Rules/*/Fixture/*.php` - Test fixtures with various naming patterns (one class/trait/interface/enum per file)

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

### Running Final Checks
Before finalizing changes, you need to ensure that formatting has been applied, static analysis is passing, and all tests are successful. It is important to run these checks in order. First check formatting, then static analysis, and finally run all tests. This is because formatting may change line numbers in tests, which can cause test failures if not done first.

## Configuration Architecture
The extension uses Neon dependency injection with a hierarchical configuration system:

1. **Schema Definition** (`config/extension.neon`): Defines parameter structure and defaults
2. **Test Overrides** (`tests/Rules/*/config/*.neon`): Override specific parameters for test scenarios
3. **Service Registration**: Config classes are auto-wired using parameter references

### Critical Pattern: Config Parameter Mapping
In `config/extension.neon`, ensure Config service arguments match the correct parameter namespace:
```neon
- factory: Orrison\MeliorStan\Rules\CamelCaseParameterName\Config
  arguments:
    - %meliorstan.camel_case_parameter_name.allow_consecutive_uppercase%  # Not property_name!
    - %meliorstan.camel_case_parameter_name.allow_underscore_prefix%
```

### Rule Registration for New Rules
When creating a new rule, you must add BOTH schema definition AND service registration to `config/extension.neon`:

1. **Add parameter schema** (in `parametersSchema` section):
```neon
parametersSchema:
    meliorstan: structure([
        # ... existing rules
        new_rule_name: structure([
            config_option: bool(),
        ]),
    ])
```

2. **Add default parameters** (in `parameters` section):
```neon
parameters:
    meliorstan:
        # ... existing rules
        new_rule_name:
            config_option: false
```

3. **Add service registration** (in `services` section):
```neon
services:
    # ... existing services
    -
        factory: Orrison\MeliorStan\Rules\NewRuleName\Config
        arguments:
            - %meliorstan.new_rule_name.config_option%
```

**IMPORTANT**: The main rule class itself is NOT registered in extension.neon. Users must register the rule in their own PHPStan configuration.

### Test Configuration Files
Test config files must include BOTH the extension config AND rule registration:

```neon
includes:
    - ../../../../config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\NewRuleName\NewRuleNameRule

parameters:
    meliorstan:
        new_rule_name:
            config_option: true  # Override for this test
```

**Critical**: Without the `rules:` section, tests will fail with "Service of type ... not found" error.

### Config Parameter Naming Conventions
When adding new rules to `config/extension.neon`, follow these naming patterns:

1. **Schema keys**: Use snake_case matching the rule directory name:
   ```neon
   boolean_get_method_name: structure([    # Directory: BooleanGetMethodName
       check_parameterized_methods: bool(),
   ])
   ```

2. **Parameter references**: Must match the schema key exactly:
   ```neon
   - factory: Orrison\MeliorStan\Rules\BooleanGetMethodName\Config
     arguments:
       - %meliorstan.boolean_get_method_name.check_parameterized_methods%
   ```

3. **Config method names**: Use camelCase with "get" prefix:
   ```php
   public function getCheckParameterizedMethods(): bool
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

## Test Conventions

### PSR-4 Fixture File Standards
**CRITICAL**: All test fixture files MUST follow PSR-4 autoloading standards:

1. **One class/trait/interface/enum per file**: Each PHP type must be in its own file
2. **Filename matches type name**: A class `MyClass` must be in `MyClass.php`
3. **No multi-type files**: Never put multiple classes, traits, interfaces, or enums in the same file

**Example - CORRECT:**
```
tests/Rules/MyRule/Fixture/
├── ExampleClass.php      # Contains only: class ExampleClass
├── AnotherClass.php      # Contains only: class AnotherClass
├── ExampleTrait.php      # Contains only: trait ExampleTrait
├── ExampleInterface.php  # Contains only: interface ExampleInterface
└── ExampleEnum.php       # Contains only: enum ExampleEnum
```

**Example - INCORRECT:**
```php
// ExampleClass.php - DON'T DO THIS
class ExampleClass {}
class AnotherClass {}  // Should be in AnotherClass.php
trait ExampleTrait {}  // Should be in ExampleTrait.php
```

When tests need multiple fixture types, list them all in the `$this->analyse()` call:
```php
$this->analyse(
    [
        __DIR__ . '/Fixture/ExampleClass.php',
        __DIR__ . '/Fixture/AnotherClass.php',
        __DIR__ . '/Fixture/ExampleTrait.php',
    ],
    [
        // expected errors with line numbers
    ]
);
```

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

### Critical: Line Number Management After Formatting
**ALWAYS run `composer format` BEFORE finalizing test line numbers!**

1. Write initial tests with approximate line numbers
2. Run `composer format` to apply code style fixes
3. Run the specific test to see actual vs expected line numbers
4. Update test assertions with correct line numbers from the failing test output
5. Re-run tests to verify they pass

**Example workflow:**
```bash
# After creating fixture and test files
composer format                    # Format all code first
./vendor/bin/phpunit tests/Rules/NewRule/DefaultTest.php  # See line number errors
# Update test with correct line numbers from failure output
./vendor/bin/phpunit tests/Rules/NewRule/DefaultTest.php  # Verify passes
```

The formatter often adds PHPDoc annotations and adjusts spacing, which changes line numbers. Doing this early prevents having to fix line numbers multiple times.

## Project-Specific Patterns

### Class Extensibility
- No classes should be marked as `final` unless absolutely necessary. This allows for easier extension and customization in the future.
- No methods or properties should be marked as `private` unless absolutely necessary. Use `protected` or `public` to allow for subclass overrides.
    - Use `protected` for methods that are intended to be overridden in subclasses, and `public` for methods that are part of the public API of the rule.
- It is okay to use `final` on classes or `private` on methods in tests if the intent is to prove that the rule works as expected in a specific scenario or if the rule is doing something specific with final classes and private methods/properties, but this should be avoided in the source code of our rules

### Namespace Convention
All classes use `Orrison\MeliorStan\` prefix with rule-specific sub-namespaces.

### Declare Strict Types
Do NOT add `declare(strict_types=1);` to the top of files. This is not a requirement for this project and we do not want it. Unless the rule specifically has to do with this strict type declaration, then it is not needed. This is to keep the codebase consistent and avoid unnecessary complexity.

### Import Statements
Always use full imports for all classes and interfaces used in the file. Do not use fully qualified class names in the code - import them explicitly at the top of the file instead. This includes:
- PHPStan classes (`PHPStan\Analyser\Scope`, `PHPStan\Rules\Rule`, etc.)
- PhpParser node classes (`PhpParser\Node`, `PhpParser\Node\Stmt\Class_`, `PhpParser\Node\Identifier`, etc.)
- All other external dependencies

Example:
```php
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
```

### Error Message Constants
**CRITICAL**: All rule error messages MUST be defined as public constants in the rule class. This improves maintainability, consistency, and makes error messages the single source of truth.

#### Static Error Messages
For rules with a single, unchanging error message, use a simple constant:

```php
class EmptyCatchBlockRule implements Rule
{
    public const ERROR_MESSAGE = 'Empty catch block is not allowed.';

    public function processNode(Node $node, Scope $scope): array
    {
        // ... validation logic ...

        return [
            RuleErrorBuilder::message(self::ERROR_MESSAGE)
                ->identifier('MeliorStan.emptyCatchBlock')
                ->build(),
        ];
    }
}
```

#### Dynamic Error Messages (Single Template)
For rules where the error message includes dynamic data (e.g., variable names, lengths), use a template constant with placeholders for `sprintf()`:

```php
class ShortMethodNameRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE = 'Method name "%s" is shorter than minimum length of %d characters.';

    public function processNode(Node $node, Scope $scope): array
    {
        // ... validation logic ...

        return [
            RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $methodName, $minimumLength)
            )
                ->identifier('MeliorStan.methodNameTooShort')
                ->build(),
        ];
    }
}
```

#### Multiple Error Message Templates
For rules that validate different contexts (e.g., properties, parameters, and variables), use separate template constants for each context:

```php
class ShortVariableRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE_PROPERTY = 'Property name "$%s" is shorter than minimum length of %d characters.';
    public const ERROR_MESSAGE_TEMPLATE_PARAMETER = 'Parameter name "$%s" is shorter than minimum length of %d characters.';
    public const ERROR_MESSAGE_TEMPLATE_VARIABLE = 'Variable name "$%s" is shorter than minimum length of %d characters.';

    public function processNode(Node $node, Scope $scope): array
    {
        // ... determine context (property, parameter, or variable) ...

        if ($isProperty) {
            $message = sprintf(self::ERROR_MESSAGE_TEMPLATE_PROPERTY, $name, $minLength);
        } elseif ($isParameter) {
            $message = sprintf(self::ERROR_MESSAGE_TEMPLATE_PARAMETER, $name, $minLength);
        } else {
            $message = sprintf(self::ERROR_MESSAGE_TEMPLATE_VARIABLE, $name, $minLength);
        }

        return [
            RuleErrorBuilder::message($message)
                ->identifier('MeliorStan.variableNameTooShort')
                ->build(),
        ];
    }
}
```

#### Test Implementation
Tests MUST use the constants instead of hardcoded strings:

**Static messages:**
```php
$this->analyse([__DIR__ . '/Fixture/Example.php'], [
    [EmptyCatchBlockRule::ERROR_MESSAGE, 14],
    [EmptyCatchBlockRule::ERROR_MESSAGE, 23],
]);
```

**Dynamic messages with single template:**
```php
$this->analyse([__DIR__ . '/Fixture/Example.php'], [
    [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'a', 3), 7],
    [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'ab', 3), 10],
]);
```

**Dynamic messages with multiple templates:**
```php
$this->analyse([__DIR__ . '/Fixture/Example.php'], [
    [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'x', 3), 9],
    [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'a', 3), 15],
    [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'b', 3), 17],
]);
```

**IMPORTANT**:
- Never use hardcoded error message strings in tests
- Variable names in sprintf should NOT include the `$` prefix (the template handles that)
- Constants should be `public` for test access
- Use descriptive constant names that indicate the message type

### Error Identifiers
Use consistent identifiers for rule errors:
```php
->identifier('MeliorStan.methodNameNotCamelCase')
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
5. **Hardcoded Error Messages**: Always use public constants for error messages in rule classes, never hardcode strings in tests or multiple places in the rule

## Contribution Guidelines
- Follow the coding standards of the project, styling defined by PHP-CS-Fixer configuration. `php-cs-fixer.php` is the config file. And `composer format` will auto-fix code style. And linting/static analysis can be run with `composer analyze` and is configured with our PHPStan configuration `phpstan.neon.dist`.
- All new rules should follow the established 3-component structure (Rule, Config, Tests) unless there's a compelling reason or asked to deviate.
- **All error messages must be defined as public constants** in the rule class (ERROR_MESSAGE, ERROR_MESSAGE_TEMPLATE, or ERROR_MESSAGE_TEMPLATE_[CONTEXT])
- **Tests must use these constants** instead of hardcoded error message strings
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
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\{Namespace}\{RuleName}Rule

parameters:
    meliorstan:
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
    meliorstan:
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
### [{Rule name without the "Rule" suffix, e.g. CamelCaseVariableName}](docs/{RuleName}.md)

{Brief one-line description matching the rule documentation}
```

### Documentation Validation
Before completing rule implementation:
1. Verify all examples are accurate and require their respective configurations
2. Ensure README.md links are functional and descriptions match
3. Check that configuration parameter names match `extension.neon`
4. Validate that error messages in examples match actual rule output
5. Ensure documentation is done for all possible configurable properties of the rule. If a rule does not have any configurable properties, it must notate that in the documentation like in `Superglobals.md`.
