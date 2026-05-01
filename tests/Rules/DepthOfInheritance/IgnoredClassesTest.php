<?php

namespace Orrison\MeliorStan\Tests\Rules\DepthOfInheritance;

use Orrison\MeliorStan\Rules\DepthOfInheritance\DepthOfInheritanceRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DepthOfInheritanceRule>
 */
class IgnoredClassesTest extends RuleTestCase
{
    public function testIgnoredClassDoesNotError(): void
    {
        // Level7 has depth 7 and max is 3, but it's in the ignored list so no error.
        // Level4 has depth 4 and max is 3, NOT ignored so it errors.
        $this->analyse(
            [
                __DIR__ . '/Fixture/Level0.php',
                __DIR__ . '/Fixture/Level1.php',
                __DIR__ . '/Fixture/Level2.php',
                __DIR__ . '/Fixture/Level3.php',
                __DIR__ . '/Fixture/Level4.php',
                __DIR__ . '/Fixture/Level5.php',
                __DIR__ . '/Fixture/Level6.php',
                __DIR__ . '/Fixture/Level7.php',
            ],
            [
                [
                    sprintf(DepthOfInheritanceRule::ERROR_MESSAGE_TEMPLATE, 'Level4', 4, 3),
                    5,
                ],
                [
                    sprintf(DepthOfInheritanceRule::ERROR_MESSAGE_TEMPLATE, 'Level5', 5, 3),
                    5,
                ],
                [
                    sprintf(DepthOfInheritanceRule::ERROR_MESSAGE_TEMPLATE, 'Level6', 6, 3),
                    5,
                ],
                // Level7 is ignored, so no error expected
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignored-classes.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DepthOfInheritanceRule::class);
    }
}
