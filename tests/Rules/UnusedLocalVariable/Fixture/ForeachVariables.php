<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class ForeachVariables
{
    /**
     * @param array<string, int> $items
     */
    public function unusedKey(array $items): int
    {
        $sum = 0;

        foreach ($items as $key => $value) {
            $sum += $value;
        }

        return $sum;
    }

    /**
     * @param array<int, int> $items
     */
    public function unusedValue(array $items): int
    {
        $count = 0;

        foreach ($items as $value) {
            $count++;
        }

        return $count;
    }

    /**
     * @param array<int, int> $items
     */
    public function bothUsed(array $items): int
    {
        $sum = 0;

        foreach ($items as $value) {
            $sum += $value;
        }

        return $sum;
    }
}
