<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class ClosureNestingClass
{
    public function build(): callable
    {
        return function (int $x): int {
            if ($x > 0) {
                return $x * 2;
            }

            return 0;
        };
    }
}
