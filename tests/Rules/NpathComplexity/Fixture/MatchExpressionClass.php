<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity\Fixture;

class MatchExpressionClass
{
    // NPath: match has 8 arms (no default) = 9 paths; combined with 8 sequential ifs: 9 * 256 >> 200
    public function processWithMatch(int $status, int $a, int $b, int $c, int $d, int $e, int $f, int $g, int $h): string
    {
        $label = match ($status) {
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
        };

        if ($a > 0) {
            echo 'a';
        }

        if ($b > 0) {
            echo 'b';
        }

        if ($c > 0) {
            echo 'c';
        }

        if ($d > 0) {
            echo 'd';
        }

        if ($e > 0) {
            echo 'e';
        }

        if ($f > 0) {
            echo 'f';
        }

        if ($g > 0) {
            echo 'g';
        }

        if ($h > 0) {
            echo 'h';
        }

        return $label;
    }
}
