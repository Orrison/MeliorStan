<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

// Cognitive complexity = 1+2+3+4+5+6 = 21
function processNested(int $a, int $b, int $c, int $d, int $e, int $f): void
{
    if ($a > 0) {
        if ($b > 0) {
            if ($c > 0) {
                if ($d > 0) {
                    if ($e > 0) {
                        if ($f > 0) {
                            echo 'all';
                        }
                    }
                }
            }
        }
    }
}
