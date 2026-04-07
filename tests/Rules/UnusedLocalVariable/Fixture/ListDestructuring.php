<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class ListDestructuring
{
    /**
     * @return array{0: int, 1: int}
     */
    public function pair(): array
    {
        return [1, 2];
    }

    public function takeFirst(): int
    {
        [$first, $second] = $this->pair();

        return $first;
    }
}
