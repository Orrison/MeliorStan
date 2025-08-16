<?php

namespace Orrison\MessStan\Tests\Rules\ShortVariable\Fixture;

use Exception;

class ExampleClassForeachAllowed
{
    public $x;

    public function exampleMethod($a)
    {
        $b = 1;

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
}
