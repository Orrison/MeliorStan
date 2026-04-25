<?php

namespace Orrison\MeliorStan\Tests\Rules\ErrorControlOperator;

use Orrison\MeliorStan\Rules\ErrorControlOperator\ErrorControlOperatorRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ErrorControlOperatorRule>
 */
class ErrorControlOperatorTest extends RuleTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/test.neon',
        ];
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ExampleWithErrors.php',
                __DIR__ . '/Fixture/ExampleWithoutErrors.php',
            ],
            [
                [ErrorControlOperatorRule::ERROR_MESSAGE, 12],
                [ErrorControlOperatorRule::ERROR_MESSAGE, 19],
                [ErrorControlOperatorRule::ERROR_MESSAGE, 26],
                [ErrorControlOperatorRule::ERROR_MESSAGE, 33],
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new ErrorControlOperatorRule();
    }
}
