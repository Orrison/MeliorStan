# CouplingBetweenObjects

Detects classes with too many type dependencies (high coupling between objects).

A class with too many dependencies has negative impacts on stability, maintainability, and understandability. This rule counts the number of unique external types referenced by a class and flags it when the count exceeds a configurable threshold. This is based on the Coupling Between Objects (CBO) metric from object-oriented design.

## Configuration

This rule supports the following configuration options:

### `maximum`
- **Type**: `int`
- **Default**: `13`
- **Description**: The maximum number of unique type dependencies a class can have before triggering a violation. Matches the PHPMD default.

### `excluded_namespaces`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: Namespace prefixes to exclude from the coupling count. Types whose fully-qualified name starts with any of these prefixes will not be counted. Useful for excluding framework namespaces like `Illuminate\` in Laravel projects.

### `excluded_types`
- **Type**: `array<string>`
- **Default**: `[]`
- **Description**: Specific fully-qualified class names to exclude from the coupling count. Useful for excluding ubiquitous types like `Carbon\Carbon` or `Illuminate\Support\Collection`.

### `count_attributes`
- **Type**: `bool`
- **Default**: `true`
- **Description**: Whether PHP 8 attributes (`#[SomeAttribute]`) should count toward the coupling value. When enabled, attribute types used on the class, properties, methods, and parameters are included in the count.

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule

parameters:
    meliorstan:
        coupling_between_objects:
            maximum: 13
            excluded_namespaces: []
            excluded_types: []
            count_attributes: true
```

## Examples

### Default Configuration

```php
<?php

use App\Services\UserService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Repositories\UserRepository;
// ... many more imports

// ✗ Error: Class has coupling value of 14, exceeds maximum of 13
class OrderController
{
    public function __construct(
        private UserService $userService,
        private OrderService $orderService,
        private PaymentService $paymentService,
        private UserRepository $userRepo,
        // ... 10 more dependencies
    ) {}

    public function process(OrderRequest $request): OrderResponse
    {
        // uses many different types...
    }
}

// ✓ Valid: Class with few dependencies (3 unique types)
class SimpleService
{
    public function __construct(
        private UserRepository $repo,
    ) {}

    public function find(int $id): User
    {
        return $this->repo->find($id);
    }
}
```

### Configuration Examples

#### Excluding Laravel Framework Namespaces

```neon
parameters:
    meliorstan:
        coupling_between_objects:
            excluded_namespaces:
                - 'Illuminate\'
```

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Services\UserService;

// ✓ Now valid: Illuminate types are excluded, only 2 non-framework types count
class UserController
{
    public function index(Request $request, UserService $service): JsonResponse
    {
        $users = $service->all();

        return new JsonResponse($users);
    }
}
```

#### Excluding Specific Types

```neon
parameters:
    meliorstan:
        coupling_between_objects:
            excluded_types:
                - 'Carbon\Carbon'
                - 'Illuminate\Support\Collection'
```

```php
<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;

// ✓ Carbon and Collection are excluded from the coupling count
class ReportService
{
    public function generate(Carbon $from, Carbon $to): Collection
    {
        // ...
    }
}
```

#### Disabling Attribute Counting

```neon
parameters:
    meliorstan:
        coupling_between_objects:
            count_attributes: false
```

```php
<?php

use App\Attributes\Validate;
use App\Attributes\Authorize;
use App\Attributes\Cache;

// ✓ Now valid: attribute types are not counted toward coupling
#[Authorize]
#[Cache]
class UserController
{
    #[Validate]
    public function store(): void {}
}
```

## What Counts as Coupling

The rule counts unique external type references from the following sources:

- **Inheritance**: `extends` and `implements` clauses
- **Trait usage**: `use` statements inside the class
- **Property types**: Typed property declarations
- **Method parameter types**: Type hints on method parameters
- **Method return types**: Return type declarations
- **Object instantiation**: `new ClassName()` expressions
- **Static access**: `ClassName::method()`, `ClassName::$property`, `ClassName::CONSTANT`
- **Exception handling**: Types in `catch` blocks
- **Type checks**: `instanceof` expressions
- **Closure/arrow function types**: Parameter and return types in closures and arrow functions
- **PHP 8 attributes**: `#[AttributeName]` on the class, properties, methods, and parameters (when `count_attributes` is enabled)

## Important Notes

- **Deduplication**: Each unique type is counted only once, regardless of how many times it appears. A type used as a property, parameter, and in a `new` expression still counts as one dependency.
- **Built-in types excluded**: PHP built-in types (`int`, `string`, `bool`, `array`, `void`, `mixed`, `null`, `self`, `static`, `parent`, etc.) are never counted.
- **Self-references excluded**: References to the class itself are not counted.
- **All class-like types**: The rule applies to classes, interfaces, traits, and enums.
- **Anonymous classes skipped**: Anonymous classes are not analyzed.
