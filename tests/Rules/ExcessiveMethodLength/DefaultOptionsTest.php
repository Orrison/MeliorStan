<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength;

use Orrison\MeliorStan\Rules\ExcessiveMethodLength\ExcessiveMethodLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveMethodLengthRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testLongMethodTriggers(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LongMethodClass.php',
                __DIR__ . '/Fixture/ShortMethodClass.php',
            ],
            [
                [
                    sprintf(ExcessiveMethodLengthRule::ERROR_MESSAGE_TEMPLATE, 'Method "longMethod"', 13, 10),
                    13,
                ],
            ]
        );
    }

    public function testStandaloneFunctions(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/StandaloneFunctions.php',
            ],
            [
                [
                    sprintf(ExcessiveMethodLengthRule::ERROR_MESSAGE_TEMPLATE, 'Function "emlLongFunction"', 13, 10),
                    11,
                ],
            ]
        );
    }

    public function testTopLevelClosures(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/TopLevelClosures.php',
            ],
            [
                [
                    sprintf(ExcessiveMethodLengthRule::ERROR_MESSAGE_TEMPLATE, 'Closure', 12, 10),
                    10,
                ],
            ]
        );
    }

    public function testAbstractAndInterfaceMethodsAreSkipped(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/AbstractMethodClass.php',
                __DIR__ . '/Fixture/InterfaceMethods.php',
            ],
            []
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveMethodLengthRule::class);
    }
}
