<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidEvalExpressions\Fixture;

class ExampleClass
{
    public function methodWithEval(): void
    {
        $code = 'echo "Hello";';
        eval($code);
    }

    public function methodWithEvalExpression(): void
    {
        eval('$x = 10; echo $x;');
    }

    public function methodWithDynamicEval(): void
    {
        $dynamicCode = '$result = 5 + 5;';
        eval($dynamicCode);
    }

    public function methodWithoutEval(): void
    {
        echo 'No eval here';
    }

    public function methodWithMultipleEvals(): void
    {
        eval('echo "First";');

        if (condition()) {
            eval('echo "Second";');
        }
    }
}
