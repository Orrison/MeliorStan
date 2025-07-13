<?php

class SecondFile
{
    public function testMethod()
    {
        // This variable has the same name as the one from FirstFile
        // If state persists, it might incorrectly be considered already processed
        $i = 'this should definitely be a violation in second file';
        
        // Another short variable to be sure
        $x = 'also short';
    }
}
