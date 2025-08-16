# MessStan

Provides custom PHPStan rules for different enforcements throughout your codebase to look for potential problems and enforce particular programmatic or naming style.

## Inspiration

Originally inspired by <a href="https://phpmd.org/" target="_blank">PHPMD - PHP Mess Detector</a>, this project attempts to provide equivalent rules with modern interpretation and maintenance.

Note that all rules inspired by PHPMD are simply that, inspired. They are often similar in their enforcements. But they are not complete 1-to-1 replications, in that they provided different or additional customization via different parameters.

Not every rule in this extention is inspired by PHPMD. Additional rules beyond those that replicate PHPMD enforcements are also provided.

## Rules

### [BooleanGetMethodName](docs/BooleanGetMethodName.md)

Enforces that methods with boolean return types should not start with "get".

### [CamelCase Method Name](docs/CamelCaseMethodName.md)

Enforces that method names should follow camelCase naming convention.

### [CamelCase Parameter Name](docs/CamelCaseParameterName.md)

Enforces that function and method parameter names should follow camelCase naming convention.

### [CamelCase Property Name](docs/CamelCasePropertyName.md)

Enforces that class property names should follow camelCase naming convention.

### [CamelCase Variable Name](docs/CamelCaseVariableName.md)

Enforces that local variable names should follow camelCase naming convention.

### [ConstantNamingConventions](docs/ConstantNamingConventions.md)

Enforces that constant names should be in UPPERCASE.

### [MissingClosureParameterTypehint](docs/MissingClosureParameterTypehint.md)

Enforces that all parameters in anonymous functions (closures) have type declarations.

### [PascalCase Class Name](docs/PascalCaseClassName.md)

Enforces that class names should follow PascalCase naming convention.

### [ShortMethodName](docs/ShortMethodName.md)

Enforces that method names must be of a minimum length.

### [ShortVariable](docs/ShortVariable.md)

Enforces that variable names must be of a minimum length.

### [Superglobals](docs/Superglobals.md)

Enforces that PHP superglobals should not be used.

### [TraitConstantNamingConventions](docs/TraitConstantNamingConventions.md)

Enforces that all trait constants use UPPERCASE naming convention.
