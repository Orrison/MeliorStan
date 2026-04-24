<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment\Fixture;

class AssignmentInIfCondition
{
    public function withFunctionCallAssignment(): void
    {
        if ($foo = someFunction()) {
        }
    }

    public function withLiteralAssignment(): void
    {
        if ($bar = 0) {
        }
    }

    public function withMethodCallAssignment(): void
    {
        if ($baz = $this->getResult()) {
        }
    }

    protected function getResult(): mixed
    {
        return null;
    }
}
