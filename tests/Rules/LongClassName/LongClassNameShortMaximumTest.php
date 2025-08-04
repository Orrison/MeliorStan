<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules;

use Orrison\MessedUpPhpstan\Rules\LongClassName\LongClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongClassNameRule>
 */
class LongClassNameShortMaximumTest extends RuleTestCase
{
    public function testShortMaximum(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ShortMaximum.php'], [
            [
                'Class name "VeryLongClassNameThatExceeds" exceeds maximum length of 20 characters (effective length: 28).',
                4,
            ],
            [
                'Class name "AnotherVeryLongClassNameHere" exceeds maximum length of 20 characters (effective length: 28).',
                5,
            ],
            [
                'Interface name "LongInterfaceNameThatExceeds" exceeds maximum length of 20 characters (effective length: 28).',
                12,
            ],
            [
                'Trait name "VeryLongTraitNameThatExceeds" exceeds maximum length of 20 characters (effective length: 28).',
                13,
            ],
            [
                'Enum name "SuperLongEnumNameExceeds" exceeds maximum length of 20 characters (effective length: 24).',
                14,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/short_maximum.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(LongClassNameRule::class);
    }
}