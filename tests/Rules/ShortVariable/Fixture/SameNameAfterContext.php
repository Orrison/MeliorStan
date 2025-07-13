<?php

class SameNameAfterContext
{
    public function testSameNameAfterAllowedContexts()
    {
        // For loop with short variable $i
        for ($i = 0; $i < 10; $i++) {
            // Loop body
        }

        // New variable $i defined AFTER the for loop - should be a violation
        $i = 'short variable after for loop';

        // Foreach with short variables $k and $v
        $items = [1, 2, 3];
        foreach ($items as $k => $v) {
            // Loop body
        }

        // New variables $k and $v defined AFTER foreach - should be violations
        $k = 'short variable after foreach';
        $v = 'short variable after foreach';

        // Try-catch with short variable $e
        try {
            throw new Exception('test');
        } catch (Exception $e) {
            // Catch body
        }

        // New variable $e defined AFTER catch - should be a violation
        $e = 'short variable after catch';
    }
}
