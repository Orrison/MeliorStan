<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortClassName;

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
        // With minimum of 2, only A.php should trigger an error
        $this->analyse([__DIR__ . '/Fixture/A.php'], [
            [
                'Class name "A" is too short (1 chars). Minimum allowed length is 2 characters.',
                5,
            ],
        ]);

        // AB.php should have no errors with minimum of 2
        $this->analyse([__DIR__ . '/Fixture/AB.php'], []);

        // ABC.php should have no errors with minimum of 2
        $this->analyse([__DIR__ . '/Fixture/ABC.php'], []);
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
