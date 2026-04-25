<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods;

use Orrison\MeliorStan\Rules\TooManyPublicMethods\TooManyPublicMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyPublicMethodsRule>
 */
class IgnoreMagicMethodsFalseTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassWithMagicMethodsExceedingLimit.php',
                __DIR__ . '/Fixture/ClassWithMagicMethods.php',
            ],
            [
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithMagicMethodsExceedingLimit', 11, 10),
                    6,
                ],
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithMagicMethods', 11, 10),
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
        return [__DIR__ . '/config/ignore_magic_methods_false.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyPublicMethodsRule::class);
    }
}
