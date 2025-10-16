<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidPestPhpOnly;

use Orrison\MeliorStan\Rules\ForbidPestPhpOnly\ForbidPestPhpOnlyRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ForbidPestPhpOnlyRule>
 */
class ForbidPestPhpOnlyRuleTest extends RuleTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/test.neon',
        ];
    }

    public function testOnlyUsageIsReported(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/InvalidPestFixture.php',
        ], [
            [ForbidPestPhpOnlyRule::ERROR_MESSAGE, 3],
            [ForbidPestPhpOnlyRule::ERROR_MESSAGE, 7],
        ]);
    }

    public function testValidUsagePasses(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ValidPestFixture.php',
            __DIR__ . '/Fixture/NonPestOnlyUsageFixture.php',
        ], []);
    }

    protected function getRule(): Rule
    {
        return new ForbidPestPhpOnlyRule();
    }
}
