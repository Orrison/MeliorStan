<?php

namespace Orrison\MeliorStan\Tests\Rules;

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
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [
                'Class name "A" is too short (1 chars). Minimum allowed length is 3 characters.',
                5,
            ],
            [
                'Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.',
                6,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/OtherTypes.php'], [
            [
                'Interface name "I" is too short (1 chars). Minimum allowed length is 3 characters.',
                5,
            ],
            [
                'Trait name "T" is too short (1 chars). Minimum allowed length is 3 characters.',
                6,
            ],
            [
                'Enum name "E" is too short (1 chars). Minimum allowed length is 3 characters.',
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
        return self::getContainer()->getByType(ShortClassNameRule::class);
    }
}
