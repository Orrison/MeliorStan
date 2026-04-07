<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class CompactUsage
{
    /**
     * @return array<string, int>
     */
    public function viaCompact(): array
    {
        $a = 1;
        $b = 2;

        return compact('a', 'b');
    }

    /**
     * @return array<string, int>
     */
    public function viaCompactWithUnused(): array
    {
        $a = 1;
        $b = 2;
        $stray = 3;

        return compact('a', 'b');
    }
}
