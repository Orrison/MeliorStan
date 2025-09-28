<?php

namespace Orrison\MeliorStan\Tests\Rules;

use Orrison\MeliorStan\Rules\LongClassName\LongClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongClassNameRule>
 */
class LongClassNameRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [
                'Class name "VeryLongClassNameThatExceedsTheDefaultMaximumLength" is too long (51 chars). Maximum allowed length is 40 characters.',
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/OtherTypes.php'], [
            [
                'Interface name "VeryLongInterfaceNameThatExceedsTheDefaultMaximumLength" is too long (55 chars). Maximum allowed length is 40 characters.',
                5,
            ],
            [
                'Trait name "VeryLongTraitNameThatExceedsTheDefaultMaximumLength" is too long (51 chars). Maximum allowed length is 40 characters.',
                6,
            ],
            [
                'Enum name "VeryLongEnumNameThatExceedsTheDefaultMaximumLength" is too long (50 chars). Maximum allowed length is 40 characters.',
                7,
            ],
        ]);
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
        return self::getContainer()->getByType(LongClassNameRule::class);
    }
}
