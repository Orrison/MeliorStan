<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable\Fixture;

use Exception;

class ExampleClassForeachAllowed
{
    public $x;  // Short property - should still be flagged

    public function exampleMethod($a) // Short param - should still be flagged
    {
        // Regular local variables - should still be flagged
        $b = 1; // Short variable

        // For loop variables - should still be flagged when only allow_in_foreach is true
        for ($i = 0; $i < 10; $i++) {
            $j = $i * 2; // Regular variable inside for loop - should still be flagged
        }

        // Foreach loop variables - should NOT be flagged when allow_in_foreach is true
        $items = [1, 2, 3];
        foreach ($items as $k => $v) {
            $temp = $v; // Regular variable in foreach - should still be flagged
        }

        // Try-catch - should still be flagged when only allow_in_foreach is true
        try {
            throw new Exception('test');
        } catch (Exception $e) {
            $msg = $e->getMessage(); // Short variable in catch - should still be flagged
        }
    }
}
