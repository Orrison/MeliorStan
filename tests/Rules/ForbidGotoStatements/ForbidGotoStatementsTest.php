<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidGotoStatements;

use Orrison\MeliorStan\Rules\ForbidGotoStatements\ForbidGotoStatementsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ForbidGotoStatementsRule>
 */
class ForbidGotoStatementsTest extends RuleTestCase
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
            ['Goto statements should not be used.', 16],
            ['Goto statements should not be used.', 22],
            ['Goto statements should not be used.', 25],
            ['Goto statements should not be used.', 40],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidGotoStatementsRule();
    }
}
