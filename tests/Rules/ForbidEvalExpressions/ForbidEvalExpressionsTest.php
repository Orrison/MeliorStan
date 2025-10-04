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
            ['Eval expressions should not be used.', 10],
            ['Eval expressions should not be used.', 15],
            ['Eval expressions should not be used.', 21],
            ['Eval expressions should not be used.', 31],
            ['Eval expressions should not be used.', 34],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidEvalExpressionsRule();
    }
}
