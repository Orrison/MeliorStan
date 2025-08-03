<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\MissingClosureParameterTypehint;

use Orrison\MessedUpPhpstan\Rules\MissingClosureParameterTypehint\MissingClosureParameterTypehintRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MissingClosureParameterTypehintRule>
 */
class MissingClosureParameterTypehintTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ExampleClass.php'],
            [
                ['Parameter #1 $name of anonymous function has no typehint.', 13],
                ['Parameter #2 $age of anonymous function has no typehint.', 13],
                ['Parameter #2 $age of anonymous function has no typehint.', 18],
                ['Parameter #1 $first of anonymous function has no typehint.', 28],
                ['Parameter #2 $second of anonymous function has no typehint.', 28],
                ['Parameter #3 $third of anonymous function has no typehint.', 28],
                ['Parameter #1 $n of anonymous function has no typehint.', 39],
                ['Parameter #1 $value of anonymous function has no typehint.', 49],
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new MissingClosureParameterTypehintRule();
    }
}
