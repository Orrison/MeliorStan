# DepthOfInheritance

Detects classes with excessively deep inheritance chains.

A class with many ancestors is tightly coupled to its entire hierarchy, making it fragile, hard to test, and difficult to understand. This rule counts the number of parent classes in a class's inheritance chain and flags it when the depth exceeds a configurable threshold. This is based on the Depth of Inheritance Tree (DIT) metric from object-oriented design.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `6`
- **Description**: The maximum allowed inheritance depth before triggering a violation. Matches the PHPMD default. A class that extends 6 or fewer parent classes will not be flagged.

### `excluded_namespaces`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: Namespace prefixes whose ancestors don't count toward the inheritance depth. Ancestors whose fully-qualified name starts with any of these prefixes are skipped when counting depth, but the walk continues past them. Useful for excluding framework namespaces like `Illuminate\` in Laravel projects where base classes add several levels of inheritance outside your control.

### `ignored_classes`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: Fully-qualified class names to skip entirely. Classes matching any entry in this list will not be checked by the rule at all. Useful for classes that naturally have deep chains due to framework design, such as Eloquent models or middleware.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\DepthOfInheritance\DepthOfInheritanceRule

parameters:
    meliorstan:
        depth_of_inheritance:
            maximum: 6
            excluded_namespaces: []
            ignored_classes: []
```

## Examples

### Default Configuration

```php
<?php

class Animal {}
class Mammal extends Animal {}
class Canine extends Mammal {}
class Dog extends Canine {}           // ✓ Valid — depth 3
class Labrador extends Dog {}         // ✓ Valid — depth 4
class ChocolateLab extends Labrador {} // ✓ Valid — depth 5
class MiniChocolateLab extends ChocolateLab {} // ✓ Valid — depth 6
class TinyMiniChocolateLab extends MiniChocolateLab {} // ✗ Error: depth 7 exceeds maximum of 6
```

### Configuration Examples

#### Lower Maximum

```neon
parameters:
    meliorstan:
        depth_of_inheritance:
            maximum: 3
```

```php
<?php

class Base {}
class Level1 extends Base {}
class Level2 extends Level1 {}
class Level3 extends Level2 {}  // ✓ Valid — depth 3
class Level4 extends Level3 {}  // ✗ Error: depth 4 exceeds maximum of 3
```

#### Excluded Namespaces

```neon
parameters:
    meliorstan:
        depth_of_inheritance:
            maximum: 3
            excluded_namespaces:
                - Illuminate\
```

```php
<?php

// Illuminate\Routing\Controller -> Illuminate\Foundation\Bus\... (framework depth ignored)
class AppController extends \Illuminate\Routing\Controller {}    // ✓ Now valid — vendor ancestors excluded
class UserController extends AppController {}                     // ✓ Now valid — depth 1 (only AppController counts)
```

#### Ignored Classes

```neon
parameters:
    meliorstan:
        depth_of_inheritance:
            maximum: 3
            ignored_classes:
                - App\Models\SpecialModel
```

```php
<?php

// App\Models\SpecialModel has deep inheritance but is ignored entirely
class SpecialModel extends DeepFrameworkBase {} // ✓ Now valid — class is skipped
```

## Important Notes

- This rule only checks classes. Interfaces, traits, and enums are not analyzed.
- Anonymous classes are skipped.
- When using `excluded_namespaces`, the rule still walks past excluded ancestors to count any non-excluded ancestors further up the chain.
- The `ignored_classes` option skips the check entirely for the specified class — it does not affect depth counting for other classes that may extend it.
