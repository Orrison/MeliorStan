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
                'Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.',
                5,
            ],
            [
                'Class name "A" is too short (1 chars). Minimum allowed length is 3 characters.',
                7,
            ],
            [
                'Interface name "AB" is too short (2 chars). Minimum allowed length is 3 characters.',
                11,
            ],
            [
                'Trait name "A" is too short (1 chars). Minimum allowed length is 3 characters.',
                13,
            ],
            [
                'Enum name "N" is too short (1 chars). Minimum allowed length is 3 characters.',
                15,
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