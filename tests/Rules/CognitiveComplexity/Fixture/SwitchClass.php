<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class SwitchClass
{
    public function topLevel(int $x): string
    {
        switch ($x) {
            case 1: return 'a';
            case 2: return 'b';

            default: return 'c';
        }
    }

    public function nested(int $x, int $y): string
    {
        if ($x > 0) {
            switch ($y) {
                case 1: return 'a';
                case 2: return 'b';

                default: return 'c';
            }
        }

        return 'fallback';
    }
}
