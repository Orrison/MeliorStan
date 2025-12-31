<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity\Fixture;

// Class with high average complexity (should trigger class-level error)
class VeryHighAverageComplexity
{
    // Complexity: 12
    public function complexMethodOne(int $a): void
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

        if ($a === 100 && $a > 50) { // 10 (if), 11 (&&)
            echo 'exact';
        }
    }

    // Complexity: 12
    public function complexMethodTwo(int $b): void
    {
        if ($b > 0) {          // 1
            if ($b > 10) {      // 2
                echo 'large';
            } elseif ($b > 5) { // 3
                echo 'medium';
            }
        } elseif ($b < 0) {    // 4
            do {               // 5
                $b++;
            } while ($b < 0);  // not counted, do is the decision point
        }

        for ($i = 0; $i < 3; $i++) { // 6
            echo $i;
        }

        foreach ([1, 2] as $v) { // 7
            echo $v;
        }

        $x = $b > 0 ? 'yes' : 'no'; // 8

        $y = $b ?? 0; // 9

        if ($b === 100 || $b < 0) { // 10 (if), 11 (||)
            echo 'edge';
        }
    }
}
