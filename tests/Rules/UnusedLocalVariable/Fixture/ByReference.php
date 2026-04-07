<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class ByReference
{
    /**
     * @return int[]
     */
    public function sortArray(): array
    {
        $items = [3, 1, 2];
        $this->sortInPlace($items);

        return $items;
    }

    /**
     * @param int[] $items
     */
    protected function sortInPlace(array &$items): void
    {
        sort($items);
    }
}
