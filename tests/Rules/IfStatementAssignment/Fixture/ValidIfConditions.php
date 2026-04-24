<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment\Fixture;

class ValidIfConditions
{
    public function withPreAssignment(): void
    {
        $foo = someFunction();

        if ($foo) {
        }
    }

    public function withStrictComparison(): void
    {
        $value = someFunction();

        if ($value === null) {
        }
    }

    public function withLooseComparison(): void
    {
        $value = someFunction();

        if ($value == false) {
        }
    }

    public function withValidElseIf(): void
    {
        if (true) {
        } elseif (false) {
        }
    }
}
