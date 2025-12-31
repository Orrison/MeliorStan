<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods;

use Orrison\MeliorStan\Rules\TooManyMethods\TooManyMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyMethodsRule>
 */
class TooManyMethodsRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassWithManyMethods.php',
                __DIR__ . '/Fixture/ClassExceedingLimit.php',
                __DIR__ . '/Fixture/ClassWithFewMethods.php',
                __DIR__ . '/Fixture/TraitExceedingLimit.php',
                __DIR__ . '/Fixture/InterfaceExceedingLimit.php',
                __DIR__ . '/Fixture/EnumExceedingLimit.php',
                __DIR__ . '/Fixture/ClassWithSixMethods.php',
            ],
            [
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 26, 25),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'TraitExceedingLimit', 26, 25),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Interface', 'InterfaceExceedingLimit', 26, 25),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Enum', 'EnumExceedingLimit', 26, 25),
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
        return self::getContainer()->getByType(TooManyMethodsRule::class);
    }
}
