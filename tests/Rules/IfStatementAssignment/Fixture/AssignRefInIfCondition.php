<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment\Fixture;

class AssignRefInIfCondition
{
    public function withReferenceAssignment(): void
    {
        $source = someFunction();

        if ($ref = &$source) {
        }
    }
}
