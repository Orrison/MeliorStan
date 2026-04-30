<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class BooleanSequenceClass
{
    public function singleAndRun(bool $a, bool $b, bool $c, bool $d): bool
    {
        if ($a && $b && $c && $d) {
            return true;
        }

        return false;
    }

    public function mixedRuns(bool $a, bool $b, bool $c, bool $d): bool
    {
        if ($a && $b || $c && $d) {
            return true;
        }

        return false;
    }
}
