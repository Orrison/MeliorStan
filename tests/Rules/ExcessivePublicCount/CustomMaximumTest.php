<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount;

use Orrison\MeliorStan\Rules\ExcessivePublicCount\ExcessivePublicCountRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessivePublicCountRule>
 */
class CustomMaximumTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/SmallClassExceedingLimit.php',
                __DIR__ . '/Fixture/ClassWithPublicProperties.php',
                __DIR__ . '/Fixture/SmallTraitExceedingLimit.php',
                __DIR__ . '/Fixture/SmallInterfaceExceedingLimit.php',
                __DIR__ . '/Fixture/SmallEnumExceedingLimit.php',
                __DIR__ . '/Fixture/ClassWithPrivateAndProtected.php',
                __DIR__ . '/Fixture/SmallDtoWithGetters.php',
            ],
            [
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'SmallClassExceedingLimit', 6, 6, 0, 5),
                    8,
                ],
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithPublicProperties', 6, 0, 6, 5),
                    9,
                ],
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'SmallTraitExceedingLimit', 6, 6, 0, 5),
                    8,
                ],
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Interface', 'SmallInterfaceExceedingLimit', 6, 6, 0, 5),
                    8,
                ],
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Enum', 'SmallEnumExceedingLimit', 6, 6, 0, 5),
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
        return [__DIR__ . '/config/custom_maximum.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessivePublicCountRule::class);
    }
}
