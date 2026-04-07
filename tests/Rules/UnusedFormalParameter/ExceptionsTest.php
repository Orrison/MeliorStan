<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter;

use Orrison\MeliorStan\Rules\UnusedFormalParameter\UnusedFormalParameterRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedFormalParameterRule>
 */
class ExceptionsTest extends RuleTestCase
{
    public function testExceptionsAreSkipped(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExceptionsFixture.php'], [
            [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'reported'), 7],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/with_exceptions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedFormalParameterRule::class);
    }
}
