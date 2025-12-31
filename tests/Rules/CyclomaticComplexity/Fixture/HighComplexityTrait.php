<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity\Fixture;

// Trait with high complexity method
trait HighComplexityTrait
{
    // Complexity: 11
    public function traitComplexMethod(int $a): void
    {
        if ($a > 0) {          // 1
            if ($a > 10) {      // 2
                echo 'large';
            } elseif ($a > 5) { // 3
                echo 'medium';
            }
        } elseif ($a < 0) {    // 4
            while ($a < 0) {   // 5
                $a++;
            }
        }

        for ($i = 0; $i < 3; $i++) { // 6
            echo $i;
        }

        foreach ([1, 2] as $v) { // 7
            echo $v;
        }

        $x = $a > 0 ? 'yes' : 'no'; // 8

        $y = $a ?? 0; // 9

        if ($a === 100) { // 10
            echo 'exact';
        }
    }
}
