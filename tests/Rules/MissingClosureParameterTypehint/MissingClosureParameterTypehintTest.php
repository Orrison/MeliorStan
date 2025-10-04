<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingClosureParameterTypehint;

use Orrison\MeliorStan\Rules\MissingClosureParameterTypehint\MissingClosureParameterTypehintRule;
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
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '1', 'name'), 13],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '2', 'age'), 13],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '2', 'age'), 18],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '1', 'first'), 28],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '2', 'second'), 28],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '3', 'third'), 28],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '1', 'n'), 39],
                [sprintf(MissingClosureParameterTypehintRule::ERROR_MESSAGE_TEMPLATE, '1', 'value'), 49],
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new MissingClosureParameterTypehintRule();
    }
}
