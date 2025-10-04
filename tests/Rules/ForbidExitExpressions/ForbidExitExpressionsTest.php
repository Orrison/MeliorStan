<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidExitExpressions;

use Orrison\MeliorStan\Rules\ForbidExitExpressions\ForbidExitExpressionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ForbidExitExpressionsRule>
 */
class ForbidExitExpressionsTest extends RuleTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/test.neon',
        ];
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 10],
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 16],
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 21],
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 26],
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 31],
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 42],
            [ForbidExitExpressionsRule::ERROR_MESSAGE, 46],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidExitExpressionsRule();
    }
}
