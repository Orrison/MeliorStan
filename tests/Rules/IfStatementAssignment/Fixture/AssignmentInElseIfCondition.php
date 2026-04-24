<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment\Fixture;

class AssignmentInElseIfCondition
{
    public function withElseIfAssignment(): void
    {
        if (true) {
        } elseif ($foo = someFunction()) {
        }
    }

    public function withMultipleElseIfAssignments(): void
    {
        if (true) {
        } elseif ($foo = someFunction()) {
        } elseif ($bar = otherFunction()) {
        }
    }
}
