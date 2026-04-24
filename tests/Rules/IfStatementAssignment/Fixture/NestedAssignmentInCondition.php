<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment\Fixture;

class NestedAssignmentInCondition
{
    public function withAndCondition(): void
    {
        if (($foo = someFunction()) && true) {
        }
    }

    public function withOrCondition(): void
    {
        if (true || ($bar = someFunction())) {
        }
    }
}
