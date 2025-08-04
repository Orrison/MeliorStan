<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules;

use Orrison\MessedUpPhpstan\Rules\LongClassName\LongClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongClassNameRule>
 */
class LongClassNameRuleTest extends RuleTestCase
{
    public function testDefaultConfiguration(): void
    {
        $this->analyse([__DIR__ . '/Fixture/DefaultConfig.php'], [
            [
                'Class name "ThisIsAnExtremelyLongClassNameThatExceedsTheDefaultMaximumLength" exceeds maximum length of 40 characters (effective length: 64).',
                8,
            ],
            [
                'Interface name "VeryVeryVeryLongInterfaceNameThatDefinitelyExceedsDefaultMaximum" exceeds maximum length of 40 characters (effective length: 64).',
                14,
            ],
            [
                'Trait name "ExtremelyLongTraitNameThatWillTriggerTheRule" exceeds maximum length of 40 characters (effective length: 44).',
                16,
            ],
            [
                'Enum name "SuperLongEnumNameThatShouldFailTheTestForSure" exceeds maximum length of 40 characters (effective length: 45).',
                18,
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