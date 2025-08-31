<?php

namespace Orrison\MeliorStan\Tests\Rules\ElseExpression\Fixture;

class ExampleClass
{
    public function justIf(): void
    {
        if ($condition) {
            doSomething();
        }
    }

    public function ifAndElseif(): void
    {
        if ($condition) {
            doSomething();
        } elseif ($otherCondition) {
            doOther();
        }
    }

    public function ifElseifAndElse(): void
    {
        if ($condition) {
            doSomething();
        } elseif ($otherCondition) {
            doOther();
        } else {
            doDefault();
        }
    }

    public function ifAndElse(): void
    {
        if ($condition) {
            doSomething();
        } else {
            doDefault();
        }
    }
}
