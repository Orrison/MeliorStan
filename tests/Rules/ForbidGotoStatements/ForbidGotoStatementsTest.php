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
            [ForbidGotoStatementsRule::ERROR_MESSAGE, 16],
            [ForbidGotoStatementsRule::ERROR_MESSAGE, 22],
            [ForbidGotoStatementsRule::ERROR_MESSAGE, 25],
            [ForbidGotoStatementsRule::ERROR_MESSAGE, 40],
        ]);
    }

    protected function getRule(): Rule
    {
        return new ForbidGotoStatementsRule();
    }
}
