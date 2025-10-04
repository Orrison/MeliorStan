<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidCountInLoopExpressions;

use Orrison\MeliorStan\Rules\ForbidCountInLoopExpressions\ForbidCountInLoopExpressionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ForbidCountInLoopExpressionsRule>
 */
class ForbidCountInLoopExpressionsTest extends RuleTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/default.neon',
        ];
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 28],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 38],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 50],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 57],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 67],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 76],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 77],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 97],
            [ForbidCountInLoopExpressionsRule::ERROR_MESSAGE, 107],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidCountInLoopExpressionsRule();
    }
}
