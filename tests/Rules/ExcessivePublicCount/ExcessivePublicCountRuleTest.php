<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount;

use Orrison\MeliorStan\Rules\ExcessivePublicCount\ExcessivePublicCountRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessivePublicCountRule>
 */
class ExcessivePublicCountRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassExceedingLimit.php',
                __DIR__ . '/Fixture/ClassAtLimit.php',
                __DIR__ . '/Fixture/DtoWithManyGetters.php',
                __DIR__ . '/Fixture/ClassWithPrivateAndProtected.php',
            ],
            [
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 46, 20, 26, 45),
                    9,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessivePublicCountRule::class);
    }
}
