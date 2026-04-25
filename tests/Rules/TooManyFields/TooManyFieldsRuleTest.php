<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields;

use Orrison\MeliorStan\Rules\TooManyFields\TooManyFieldsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyFieldsRule>
 */
class TooManyFieldsRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassExceedingLimit.php',
                __DIR__ . '/Fixture/ClassAtLimit.php',
                __DIR__ . '/Fixture/ClassWithFewFields.php',
                __DIR__ . '/Fixture/ClassWithStaticFields.php',
                __DIR__ . '/Fixture/TraitExceedingLimit.php',
                __DIR__ . '/Fixture/TraitAtLimit.php',
                __DIR__ . '/Fixture/InterfaceWithConstants.php',
            ],
            [
                [
                    sprintf(TooManyFieldsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 16, 15),
                    6,
                ],
                [
                    sprintf(TooManyFieldsRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'TraitExceedingLimit', 16, 15),
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
        return self::getContainer()->getByType(TooManyFieldsRule::class);
    }
}
