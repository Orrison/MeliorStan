<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class DeeplyNestedClass
{
    public function process(int $a, int $b, int $c, int $d, int $e, int $f): void
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
}
