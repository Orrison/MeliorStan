<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassLength;

use Orrison\MeliorStan\Rules\ExcessiveClassLength\ExcessiveClassLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassLengthRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testLongClassTriggers(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LongClass.php',
                __DIR__ . '/Fixture/ShortClass.php',
            ],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Class "LongClass"', 14, 5),
                    5,
                ],
            ]
        );
    }

    public function testLongInterfaceTriggers(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LongInterface.php',
            ],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Interface "LongInterface"', 14, 5),
                    5,
                ],
            ]
        );
    }

    public function testLongTraitTriggers(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LongTrait.php',
            ],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Trait "LongTrait"', 14, 5),
                    5,
                ],
            ]
        );
    }

    public function testLongEnumTriggers(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LongEnum.php',
            ],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Enum "LongEnum"', 9, 5),
                    5,
                ],
            ]
        );
    }

    public function testAnonymousClassThatExceedsMaximumTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/AnonymousClassHolder.php'],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Anonymous class', 13, 5),
                    5,
                ],
            ]
        );
    }

    public function testSmallAnonymousClassNoError(): void
    {
        $this->analyse([__DIR__ . '/Fixture/SmallAnonymousClassHolder.php'], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassLengthRule::class);
    }
}
