<?php

namespace Orrison\MeliorStan\Tests\Rules;

use Orrison\MeliorStan\Rules\ShortClassName\ShortClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortClassNameRule>
 */
class CustomMinimumTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/CustomMinimumClass.php'], [
            [
                'Class name "A" is too short (1 chars). Minimum allowed length is 2 characters.',
                5,
            ],
            [
                'Trait name "X" is too short (1 chars). Minimum allowed length is 2 characters.',
                11,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_minimum.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortClassNameRule::class);
    }
}