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
            ['Exit expressions should not be used.', 10],
            ['Exit expressions should not be used.', 16],
            ['Exit expressions should not be used.', 21],
            ['Exit expressions should not be used.', 26],
            ['Exit expressions should not be used.', 31],
            ['Exit expressions should not be used.', 42],
            ['Exit expressions should not be used.', 46],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidExitExpressionsRule();
    }
}
