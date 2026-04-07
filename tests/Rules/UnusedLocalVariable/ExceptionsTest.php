<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable;

use Orrison\MeliorStan\Rules\UnusedLocalVariable\UnusedLocalVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedLocalVariableRule>
 */
class ExceptionsTest extends RuleTestCase
{
    public function testExceptionsAreSkipped(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExceptionsFixture.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'reported'), 11],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/with_exceptions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedLocalVariableRule::class);
    }
}
