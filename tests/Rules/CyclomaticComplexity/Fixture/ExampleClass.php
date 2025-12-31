<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity\Fixture;

use Exception;
use RuntimeException;

class LowComplexityClass
{
    // Complexity: 1 (no decision points)
    public function simpleMethod(): void
    {
        $x = 1;
    }

    // Complexity: 2 (1 if)
    public function methodWithOneIf(): void
    {
        if (true) {
            echo 'test';
        }
    }

    // Complexity: 5 (4 decision points)
    public function methodWithComplexityFive(int $a, int $b): void
    {
        if ($a > 0) {
            echo 'positive';
        } elseif ($a < 0) {
            echo 'negative';
        }

        while ($b > 0) {
            $b--;
        }

        for ($i = 0; $i < 5; $i++) {
            echo $i;
        }
    }
}

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
