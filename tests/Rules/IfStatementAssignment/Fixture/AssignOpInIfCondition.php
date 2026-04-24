<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment\Fixture;

class AssignOpInIfCondition
{
    public function withCoalesceAssignment(): void
    {
        $foo = null;

        if ($foo ??= someFunction()) {
        }
    }

    public function withPlusAssignment(): void
    {
        $count = 0;

        if ($count += 1) {
        }
    }
}
