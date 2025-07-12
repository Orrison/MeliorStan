# Messed Up PHPStan

Provides custom PHPStan rules for different enforcements throughout your codebase to look for potential probems and enforce particular programatic or naming style.

## Inspiration

Originally inspired by [PHPMD - PHP Mess Detector](https://phpmd.org/), this project attempts to provide equivalent rules with modern interpretation and maintenance.

Note that all rules inspired by PHPMD are simply that, inspired. They are often similiar in their enforcements. But they are not complete 1-to-1 replications, in that they provided different or additional customization via different parameters.

Not every rule in this extention is inspired by PHPMD. Additional rules beyond those that replicate PHPMD enforcements are also provided.

## Rules

### [Superglobals](docs/Superglobals.md)

Enforces that PHP superglobals should not be used.
