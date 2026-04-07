<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class CompactParam
{
    public function build(int $a, int $b): array
    {
        return compact('a', 'b');
    }
}
