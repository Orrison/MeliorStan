<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods;

use Orrison\MeliorStan\Rules\TooManyPublicMethods\TooManyPublicMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyPublicMethodsRule>
 */
class TooManyPublicMethodsRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassExceedingLimit.php',
                __DIR__ . '/Fixture/ClassAtLimit.php',
                __DIR__ . '/Fixture/ClassWithFewMethods.php',
                __DIR__ . '/Fixture/ClassWithMagicMethods.php',
                __DIR__ . '/Fixture/TraitExceedingLimit.php',
                __DIR__ . '/Fixture/InterfaceExceedingLimit.php',
                __DIR__ . '/Fixture/EnumExceedingLimit.php',
            ],
            [
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 11, 10),
                    6,
                ],
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'TraitExceedingLimit', 11, 10),
                    6,
                ],
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Interface', 'InterfaceExceedingLimit', 11, 10),
                    6,
                ],
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Enum', 'EnumExceedingLimit', 11, 10),
                    6,
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
        return self::getContainer()->getByType(TooManyPublicMethodsRule::class);
    }
}
