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
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 28],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 38],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 50],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 57],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 67],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 76],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 77],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 97],
            ['Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.', 107],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidCountInLoopExpressionsRule();
    }
}
