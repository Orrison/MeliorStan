<?php

class ThirdFile
{
    public function testMethod()
    {
        // More variables with same names as previous files
        $i = 'third file variable';
        $x = 'third file x';
        
        // And a foreach that should be exempt
        $items = [1, 2, 3];
        foreach ($items as $k => $v) {
            // Loop body
        }
        
        // These should be violations since they're after foreach
        $k = 'after foreach';
        $v = 'after foreach'; 
    }
}
