<?php

namespace Orrison\MessStan\Tests\Rules\ShortVariable\Fixture;

use Exception;

class ExampleClass
{
    public $x;

    public $id;

    public $validPropertyName;

    public function exampleMethod($a, $id, $validParameterName)
    {
        $b = 1;
        $cd = 2;
        $validVariableName = 3;

        for ($i = 0; $i < 10; $i++) {
            $j = $i * 2;
        }

        $items = [1, 2, 3];

        foreach ($items as $k => $v) {
            $temp = $v;
        }

        try {
            throw new Exception('test');
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
    }

    public function methodWithShortParams($x, $y, $validParam)
    {
        return $x + $y + $validParam;
    }
}
