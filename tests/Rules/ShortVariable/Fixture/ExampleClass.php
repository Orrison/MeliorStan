<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable\Fixture;

use Exception;

class ExampleClass
{
    public $x;  // Short property

    public $id; // Short property

    public $validPropertyName; // Valid property

    public function exampleMethod($a, $id, $validParameterName)
    {
        // Local variables
        $b = 1; // Short variable
        $cd = 2; // Short variable
        $validVariableName = 3; // Valid variable

        // For loop
        for ($i = 0; $i < 10; $i++) {
            $j = $i * 2; // Short variable in for loop
        }

        // Foreach loop
        $items = [1, 2, 3];

        foreach ($items as $k => $v) {
            $temp = $v; // Short variable in foreach
        }

        // Try-catch
        try {
            throw new Exception('test');
        } catch (Exception $e) {
            $msg = $e->getMessage(); // Short variable in catch
        }
    }

    public function methodWithShortParams($x, $y, $validParam)
    {
        return $x + $y + $validParam;
    }
}
