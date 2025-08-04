# Short Variable

This rule enforces a minimum length for variable names, including local variables, parameters, and properties. It supports configurable exemptions for variables defined in specific contexts like for loops, foreach loops, and catch blocks.

## Rule Details

The rule checks that all variable names meet the configured minimum length requirement. This helps ensure code readability by discouraging overly abbreviated variable names.

### Examples

❌ **Incorrect** (with default configuration):

```php
<?php

class Example
{
    public $x;  // ✗ Error: Property too short
    
    public function method($a, $id) // ✗ Error: Parameters too short  
    {
        $b = 1;      // ✗ Error: Variable too short
        $cd = 2;     // ✗ Error: Variable too short
        
        for ($i = 0; $i < 10; $i++) { // ✗ Error: Variables too short
            $j = $i * 2; // ✗ Error: Variable too short
        }
        
        foreach ($items as $k => $v) { // ✗ Error: Variables too short
            // ...
        }
        
        try {
            // ...
        } catch (Exception $e) { // ✗ Error: Parameter too short
            $msg = $e->getMessage(); // ✗ Error: Variable too short
        }
    }
}
```

✅ **Correct** (with default configuration):

```php
<?php

class Example
{
    public $name;  // ✓ Valid: Property meets minimum length
    
    public function method($param, $userId) // ✓ Valid: Parameters meet minimum length
    {
        $result = 1;       // ✓ Valid: Variable meets minimum length
        $value = 2;        // ✓ Valid: Variable meets minimum length
        
        for ($index = 0; $index < 10; $index++) { // ✓ Valid: Variables meet minimum length
            $doubled = $index * 2; // ✓ Valid: Variable meets minimum length
        }
        
        foreach ($items as $key => $item) { // ✓ Valid: Variables meet minimum length
            // ...
        }
        
        try {
            // ...
        } catch (Exception $exception) { // ✓ Valid: Parameter meets minimum length
            $message = $exception->getMessage(); // ✓ Valid: Variable meets minimum length
        }
    }
}
```

## Configuration

You can configure this rule using the following parameters:

```neon
parameters:
    messed_up:
        short_variable:
            minimum_length: 3        # Minimum required length (default: 3)
            exceptions: []           # Array of variable names to ignore (default: [])
            allow_in_for_loops: false    # Allow short variables in for loop declarations (default: false)
            allow_in_foreach: false      # Allow short variables in foreach declarations (default: false)
            allow_in_catch: false        # Allow short variables in catch blocks (default: false)
```

### `minimum_length`

**Type:** `int`  
**Default:** `3`

Sets the minimum required length for variable names.

**Example:**
```neon
parameters:
    messed_up:
        short_variable:
            minimum_length: 5
```

### `exceptions`

**Type:** `string[]`  
**Default:** `[]`

An array of variable names that should be excluded from the minimum length check. This is useful for common short variable names that are widely accepted in the PHP community.

**Example:**
```neon
parameters:
    messed_up:
        short_variable:
            exceptions: ['i', 'j', 'k', 'x', 'y', 'e']
```

With this configuration, variables named `$i`, `$j`, `$k`, `$x`, `$y`, and `$e` would be allowed regardless of the minimum length setting.

### `allow_in_for_loops`

**Type:** `bool`  
**Default:** `false`

Allows short variable names in for loop initialization expressions.

**Example:**
```neon
parameters:
    messed_up:
        short_variable:
            allow_in_for_loops: true
```

```php
<?php

// ✓ Valid with allow_in_for_loops: true
for ($i = 0; $i < 10; $i++) {
    // $i is allowed in for loop context
}

// ✗ Error: Variables after for loop still flagged
$i = 5; // Still a violation
```

### `allow_in_foreach`

**Type:** `bool`  
**Default:** `false`

Allows short variable names in foreach key and value declarations.

**Example:**
```neon
parameters:
    messed_up:
        short_variable:
            allow_in_foreach: true
```

```php
<?php

// ✓ Valid with allow_in_foreach: true
foreach ($items as $k => $v) {
    // $k and $v are allowed in foreach context
}

// ✗ Error: Variables after foreach still flagged
$k = 'key'; // Still a violation
$v = 'value'; // Still a violation
```

### `allow_in_catch`

**Type:** `bool`  
**Default:** `false`

Allows short variable names in catch block exception declarations.

**Example:**
```neon
parameters:
    messed_up:
        short_variable:
            allow_in_catch: true
```

```php
<?php

try {
    // Some code that might throw
} catch (Exception $e) {
    // ✓ Valid with allow_in_catch: true
    // $e is allowed in catch context
}

// ✗ Error: Variables after catch still flagged
$e = new Exception(); // Still a violation
```

## Applies To

This rule checks:
- ✅ Local variables
- ✅ Function/method parameters
- ✅ Class properties
- ✅ Variables in all contexts (unless specifically exempted by configuration)

### Context-Specific Exemptions

You can exempt variables in specific contexts:

- **`allow_in_for_loops: true`** - Exempts variables declared in `for ($i = 0; ...)` initialization expressions
- **`allow_in_foreach: true`** - Exempts key and value variables in `foreach ($items as $key => $value)`
- **`allow_in_catch: true`** - Exempts exception variables in `catch (Exception $e)`

**Important:** Variables with the same names used *outside* these contexts will still be flagged as violations.

## Error Messages

The rule produces different error messages depending on the type of variable:

- **Variables:** `Variable name "$x" is shorter than minimum length of 3 characters.`
- **Parameters:** `Parameter name "$a" is shorter than minimum length of 3 characters.`
- **Properties:** `Property name "$id" is shorter than minimum length of 3 characters.`
