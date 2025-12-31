<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity\Fixture;

class HighComplexityClass
{
    // Complexity: 10 (exactly at threshold, should NOT trigger error)
    public function methodWithComplexityTen(int $a): void
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
    }

    // Complexity: 11 (exceeds threshold, should trigger error)
    public function methodWithComplexityEleven(int $a): void
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

    // Complexity: 15 (well exceeds threshold)
    public function veryComplexMethod(int $a, int $b): void
    {
        if ($a > 0) {          // 1
            if ($a > 10) {      // 2
                echo 'large';
            } elseif ($a > 5) { // 3
                echo 'medium';
            } elseif ($a > 2) { // 4
                echo 'small';
            }
        } elseif ($a < 0) {    // 5
            while ($a < 0) {   // 6
                $a++;
            }
        }

        for ($i = 0; $i < 3; $i++) { // 7
            foreach ([1, 2] as $v) { // 8
                echo $v;
            }
        }

        switch ($b) {
            case 1:                 // 9
                echo 'one';

                break;
            case 2:                 // 10
                echo 'two';

                break;
            case 3:                 // 11
                echo 'three';

                break;

            default:
                echo 'other';
        }

        $x = $a > 0 && $b > 0 ? 'both' : 'not'; // 12 (&&), 13 (ternary)

        $y = $a || $b; // 14
    }
}
