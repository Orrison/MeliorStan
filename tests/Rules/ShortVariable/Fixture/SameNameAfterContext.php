<?php

class SameNameAfterContext
{
    public function testSameNameAfterAllowedContexts()
    {
        for ($i = 0; $i < 10; $i++) {
            // Loop body
        }

        $i = 'short variable after for loop';

        $items = [1, 2, 3];

        foreach ($items as $k => $v) {
            // Loop body
        }

        $k = 'short variable after foreach';
        $v = 'short variable after foreach';

        try {
            throw new Exception('test');
        } catch (Exception $e) {
            // Catch body
        }

        $e = 'short variable after catch';
    }
}
