<?php

class FirstFile
{
    public function testMethod()
    {
        // For loop with short variable that should be exempt
        for ($i = 0; $i < 10; $i++) {
            // Loop body
        }
        
        // This should NOT be exempt since it's after the for loop
        $i = 'should be violation';
    }
}
