# Short Variable

This rule enforces a minimum length for variable names, including local variables, parameters, and properties.

## Rule Details

The rule checks that all variable names meet the configured minimum length requirement. This helps ensure code readability by discouraging overly abbreviated variable names.

### Examples

❌ **Incorrect** (with default minimum length of 3):

```php
class Example
{
    public $x;  // Property too short
    
    public function method($a, $id) // Parameters too short  
    {
        $b = 1;      // Variable too short
        $cd = 2;     // Variable too short
        
        for ($i = 0; $i < 10; $i++) { // Variables too short
            $j = $i * 2;
        }
        
        foreach ($items as $k => $v) { // Variables too short
            // ...
        }
        
        try {
            // ...
        } catch (Exception $e) { // Parameter too short
            $msg = $e->getMessage(); // Variable too short
        }
    }
}
```

✅ **Correct**:

```php
class Example
{
    public $name;  // Property meets minimum length
    
    public function method($param, $userId) // Parameters meet minimum length
    {
        $result = 1;       // Variable meets minimum length
        $value = 2;        // Variable meets minimum length
        
        for ($index = 0; $index < 10; $index++) {
            $doubled = $index * 2;
        }
        
        foreach ($items as $key => $item) {
            // ...
        }
        
        try {
            // ...
        } catch (Exception $exception) {
            $message = $exception->getMessage();
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

## Applies To

This rule checks:
- ✅ Local variables
- ✅ Function/method parameters
- ✅ Class properties
- ✅ Variables in all contexts (for loops, foreach loops, catch blocks, etc.)

## Error Messages

The rule produces different error messages depending on the type of variable:

- **Variables:** `Variable name "$x" is shorter than minimum length of 3 characters.`
- **Parameters:** `Parameter name "$a" is shorter than minimum length of 3 characters.`
- **Properties:** `Property name "$id" is shorter than minimum length of 3 characters.`
