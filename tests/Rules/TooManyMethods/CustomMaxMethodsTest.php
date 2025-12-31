<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods;

use Orrison\MeliorStan\Rules\TooManyMethods\TooManyMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Tests with custom max_methods=5
 *
 * @extends RuleTestCase<TooManyMethodsRule>
 */
class CustomMaxMethodsTest extends RuleTestCase
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
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithManyMethods', 10, 5),
                    15,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 26, 5),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'TraitExceedingLimit', 26, 5),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Interface', 'InterfaceExceedingLimit', 26, 5),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Enum', 'EnumExceedingLimit', 26, 5),
                    9,
                ],
                [
                    sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithSixMethods', 6, 5),
                    8,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_max_methods.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyMethodsRule::class);
    }
}
