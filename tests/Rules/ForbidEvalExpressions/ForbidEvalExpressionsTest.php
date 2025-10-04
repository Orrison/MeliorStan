<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidEvalExpressions;

use Orrison\MeliorStan\Rules\ForbidEvalExpressions\ForbidEvalExpressionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ForbidEvalExpressionsRule>
 */
class ForbidEvalExpressionsTest extends RuleTestCase
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
            [ForbidEvalExpressionsRule::ERROR_MESSAGE, 10],
            [ForbidEvalExpressionsRule::ERROR_MESSAGE, 15],
            [ForbidEvalExpressionsRule::ERROR_MESSAGE, 21],
            [ForbidEvalExpressionsRule::ERROR_MESSAGE, 31],
            [ForbidEvalExpressionsRule::ERROR_MESSAGE, 34],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidEvalExpressionsRule();
    }
}
