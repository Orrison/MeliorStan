# NumberOfChildren

Detects classes with too many direct child classes (subclasses).

This rule helps identify potential design issues where a class has excessive direct subclasses, which may indicate that the class hierarchy should be refactored or that the parent class is too general. Having too many direct children can make the codebase harder to maintain and understand.

## Configuration

This rule supports the following configuration option:

### `maximum`
- **Type**: `int`
- **Default**: `15`
- **Description**: The maximum number of direct child classes a class can have before triggering a violation. For example, if set to `15`, a class with 16 or more direct subclasses will be flagged.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\NumberOfChildren\NumberOfChildrenRule

parameters:
    meliorstan:
        number_of_children:
            maximum: 15
```

## Examples

### Default Configuration

```php
<?php

// ✓ Valid: class with no children
class SingleClass
{
}

// ✓ Valid: class with children within the limit (3 children, maximum is 15)
class AcceptableParent
{
}

class Child1 extends AcceptableParent {}
class Child2 extends AcceptableParent {}
class Child3 extends AcceptableParent {}

// ✗ Error: class with too many direct children (16 children, exceeds maximum of 15)
class TooManyChildren
{
}

class Child1 extends TooManyChildren {}
class Child2 extends TooManyChildren {}
// ... 14 more children
class Child16 extends TooManyChildren {}
```

### Configuration Examples

#### Lower Maximum Threshold

```neon
parameters:
    meliorstan:
        number_of_children:
            maximum: 5
```

```php
<?php

// ✗ Now valid: class with 6 children (exceeds maximum of 5)
class PopularParent
{
}

class Child1 extends PopularParent {}
class Child2 extends PopularParent {}
class Child3 extends PopularParent {}
class Child4 extends PopularParent {}
class Child5 extends PopularParent {}
class Child6 extends PopularParent {} // ✗ This 6th child causes the violation
```

## Important Notes

- **Direct children only**: This rule counts only direct subclasses (classes that directly extend the parent), not grandchildren or deeper descendants.
- **Cross-file analysis**: The rule uses PHPStan collectors to analyze class hierarchies across all files in your project.
- **Per-class violation**: The violation is reported on the parent class, not on its children.
- **Design consideration**: A high number of direct children often suggests that the parent class may be too generic or that the hierarchy could benefit from intermediate abstract classes or interfaces.
