<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter;

use Orrison\MeliorStan\Rules\UnusedFormalParameter\UnusedFormalParameterRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedFormalParameterRule>
 */
class DisallowOverridingMethodsTest extends RuleTestCase
{
    public function testOverridingMethodReported(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/OverridingParent.php',
                __DIR__ . '/Fixture/OverridingChild.php',
            ],
            [
                [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'name'), 7],
            ],
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/disallow_overriding.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedFormalParameterRule::class);
    }
}
