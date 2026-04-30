<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class GotoClass
{
    public function jump(int $x): int
    {
        if ($x > 0) {
            goto end;
        }

        end:
        return 0;
    }
}
