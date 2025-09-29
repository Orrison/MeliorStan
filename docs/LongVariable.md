# Long Variable

This rule enforces a maximum length for variable names, including local variables, parameters, and properties. It supports configurable exemptions for variables defined in specific contexts like for loops, foreach loops, and catch blocks, as well as prefix and suffix subtraction for more flexible naming conventions.

## Rule Details

The rule checks that all variable names do not exceed the configured maximum length requirement. This helps maintain code readability by discouraging overly verbose variable names that can make code harder to read and maintain.

### Examples

❌ **Incorrect** (with default configuration):

```php
<?php

class Example
{
    public $veryLongPropertyNameThatExceedsTheMaximumLength;  // ✗ Error: Property too long
    
    public function method($veryLongParameterNameThatExceedsTheMaximumLength, $anotherVeryLongParameterNameThatIsAlsoTooLong) // ✗ Error: Parameters too long
    {
        $veryLongVariableNameThatExceedsTheMaximumLength = 1; // ✗ Error: Variable too long
        $anotherVeryLongVariableNameThatIsAlsoTooLong = 2;    // ✗ Error: Variable too long
        
        for ($veryLongLoopVariableNameThatExceedsTheMaximumLength = 0; $veryLongLoopVariableNameThatExceedsTheMaximumLength < 10; $veryLongLoopVariableNameThatExceedsTheMaximumLength++) { // ✗ Error: Variables too long
            $anotherVeryLongLoopVariableNameThatIsAlsoTooLong = $veryLongLoopVariableNameThatExceedsTheMaximumLength * 2; // ✗ Error: Variable too long
        }
        
        foreach ($items as $veryLongKeyVariableNameThatExceedsTheMaximumLength => $veryLongValueVariableNameThatExceedsTheMaximumLength) { // ✗ Error: Variables too long
            // ...
        }
        
        try {
            // ...
        } catch (Exception $veryLongExceptionVariableNameThatExceedsTheMaximumLength) { // ✗ Error: Parameter too long
            $message = $veryLongExceptionVariableNameThatExceedsTheMaximumLength->getMessage(); // ✗ Error: Variable too long
        }
    }
}
```

✅ **Correct** (with default configuration):

```php
<?php

class Example
{
    public $userName;  // ✓ Valid: Property within length limit
    
    public function method($userName, $userEmail) // ✓ Valid: Parameters within length limit
    {
        $result = 1;       // ✓ Valid: Variable within length limit
        $userData = 2;     // ✓ Valid: Variable within length limit
        
        for ($index = 0; $index < 10; $index++) { // ✓ Valid: Variables within length limit
            $calculatedValue = $index * 2; // ✓ Valid: Variable within length limit
        }
        
        foreach ($items as $itemKey => $itemValue) { // ✓ Valid: Variables within length limit
            // ...
        }
        
        try {
            // ...
        } catch (Exception $exception) { // ✓ Valid: Parameter within length limit
            $errorMessage = $exception->getMessage(); // ✓ Valid: Variable within length limit
        }
    }
}
```

## Configuration

You can configure this rule using the following parameters:

```neon
parameters:
    meliorstan:
        long_variable:
            maximum: 20                    # Maximum allowed length (default: 20)
            subtract_prefixes: []          # Array of prefixes to subtract from length calculation (default: [])
            subtract_suffixes: []          # Array of suffixes to subtract from length calculation (default: [])
            allow_in_for_loops: false      # Allow long variables in for loop declarations (default: false)
            allow_in_foreach: false        # Allow long variables in foreach declarations (default: false)
            allow_in_catch: false          # Allow long variables in catch blocks (default: false)
            exceptions: []                 # Array of variable names to ignore (default: [])
```

### `maximum`

**Type:** `int`  
**Default:** `20`

Sets the maximum allowed length for variable names.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            maximum: 25
```

### `subtract_prefixes`

**Type:** `string[]`  
**Default:** `[]`

An array of prefixes to subtract from the variable name length calculation. Only the first matching prefix is subtracted.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            subtract_prefixes: ['veryLong', 'super']
```

```php
<?php

// With subtract_prefixes: ['veryLong']
$veryLongVariableName = 'test'; // Length calculated as: strlen('VariableName') = 12
$superLongVariableName = 'test'; // Length calculated as: strlen('superLongVariableName') = 21 (no prefix match)
```

### `subtract_suffixes`

**Type:** `string[]`  
**Default:** `[]`

An array of suffixes to subtract from the variable name length calculation. Only the first matching suffix is subtracted.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            subtract_suffixes: ['ThatExceedsTheMaximumLength', 'Variable']
```

```php
<?php

// With subtract_suffixes: ['ThatExceedsTheMaximumLength']
$veryLongVariableNameThatExceedsTheMaximumLength = 'test'; // Length calculated as: strlen('veryLongVariableName') = 20
$userNameVariable = 'test'; // Length calculated as: strlen('userName') = 8
```

### `allow_in_for_loops`

**Type:** `bool`  
**Default:** `false`

Allows long variable names in for loop initialization expressions.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            allow_in_for_loops: true
```

```php
<?php

// ✓ Valid with allow_in_for_loops: true
for ($veryLongLoopVariableNameThatExceedsTheMaximumLength = 0; $veryLongLoopVariableNameThatExceedsTheMaximumLength < 10; $veryLongLoopVariableNameThatExceedsTheMaximumLength++) {
    // Long variable names allowed in for loop context
}

// ✗ Error: Variables after for loop still flagged
$veryLongVariableNameThatExceedsTheMaximumLength = 5; // Still a violation
```

### `allow_in_foreach`

**Type:** `bool`  
**Default:** `false`

Allows long variable names in foreach loop declarations.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            allow_in_foreach: true
```

```php
<?php

$items = [1, 2, 3];

// ✓ Valid with allow_in_foreach: true
foreach ($items as $veryLongKeyVariableNameThatExceedsTheMaximumLength => $veryLongValueVariableNameThatExceedsTheMaximumLength) {
    // Long variable names allowed in foreach context
}

// ✗ Error: Variables after foreach still flagged
$veryLongVariableNameThatExceedsTheMaximumLength = 5; // Still a violation
```

### `allow_in_catch`

**Type:** `bool`  
**Default:** `false`

Allows long variable names in catch block exception variables.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            allow_in_catch: true
```

```php
<?php

try {
    // ...
} catch (Exception $veryLongExceptionVariableNameThatExceedsTheMaximumLength) {
    // ✓ Valid with allow_in_catch: true
    // Long variable names allowed in catch context
}

// ✗ Error: Variables after catch still flagged
$veryLongVariableNameThatExceedsTheMaximumLength = 5; // Still a violation
```

### `exceptions`

**Type:** `string[]`  
**Default:** `[]`

An array of variable names that should be excluded from the maximum length check. This is useful for specific variable names that are intentionally long for clarity or convention.

**Example:**
```neon
parameters:
    meliorstan:
        long_variable:
            exceptions: ['veryLongVariableNameThatIsAcceptable', 'anotherLongVariableName']
```

## Usage

Add the rule to your PHPStan configuration:

```neon
includes:
    - vendor/orrison/meliorstan/config/extension.neon

rules:
    - Orrison\MeliorStan\Rules\LongVariable\LongVariableRule

parameters:
    meliorstan:
        long_variable:
            maximum: 20
            subtract_prefixes: []
            subtract_suffixes: []
            allow_in_for_loops: false
            allow_in_foreach: false
            allow_in_catch: false
            exceptions: []
```

## Important Notes

- The rule processes variables in the following order: properties, parameters, and then regular variables
- Variables defined in special contexts (for loops, foreach, catch) are tracked to avoid duplicate violations
- Prefix and suffix subtraction is applied before length comparison