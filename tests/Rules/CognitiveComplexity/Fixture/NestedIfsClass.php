<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class NestedIfsClass
{
    public function process(int $a, int $b, int $c, int $d, int $e): void
    {
        if ($a > 0) {
            if ($b > 0) {
                if ($c > 0) {
                    if ($d > 0) {
                        if ($e > 0) {
                            echo 'all';
                        }
                    }
                }
            }
        }
    }
}
