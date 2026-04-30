<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class MultiLevelBreakClass
{
    /**
     * @param array<array<int|null>> $groups
     */
    public function search(array $groups): void
    {
        foreach ($groups as $group) {
            foreach ($group as $item) {
                if ($item === null) {
                    break 2;
                }
            }
        }
    }
}
