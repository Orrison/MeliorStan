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
        $errorMessage = 'Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.';

        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [$errorMessage, 28],
            [$errorMessage, 38],
            [$errorMessage, 50],
            [$errorMessage, 57],
            [$errorMessage, 67],
            [$errorMessage, 76],
            [$errorMessage, 77],
            [$errorMessage, 97],
            [$errorMessage, 107],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidCountInLoopExpressionsRule();
    }
}
