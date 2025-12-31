<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity\Fixture;

use Exception;
use RuntimeException;

// Test catch blocks and logical operators
class CatchAndLogicalOperators
{
    // Complexity: 7 (2 catch + if + 3 logical operators)
    public function methodWithCatchBlocks(): void
    {
        try {
            throw new Exception();
        } catch (RuntimeException $e) { // 1
            echo 'runtime';
        } catch (Exception $e) {        // 2
            echo 'exception';
        }

        $a = true and false;  // 3
        $b = true or false;   // 4
        $c = true && false;   // 5
        $d = true || false;   // 6
    }
}
