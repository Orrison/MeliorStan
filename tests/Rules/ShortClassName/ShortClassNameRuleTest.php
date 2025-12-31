<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortClassName;

use Orrison\MeliorStan\Rules\ShortClassName\ShortClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortClassNameRule>
 */
class ShortClassNameRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/A.php'], [
            [
                'Class name "A" is too short (1 chars). Minimum allowed length is 3 characters.',
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/AB.php'], [
            [
                'Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.',
                5,
            ],
        ]);

        // ABC.php should have no errors as it meets the minimum length of 3

        $this->analyse([__DIR__ . '/Fixture/I.php'], [
            [
                'Interface name "I" is too short (1 chars). Minimum allowed length is 3 characters.',
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/T.php'], [
            [
                'Trait name "T" is too short (1 chars). Minimum allowed length is 3 characters.',
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/E.php'], [
            [
                'Enum name "E" is too short (1 chars). Minimum allowed length is 3 characters.',
                5,
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
        return self::getContainer()->getByType(ShortClassNameRule::class);
    }
}
