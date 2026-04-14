<?php

namespace Orrison\MeliorStan\Tests\Rules\DepthOfInheritance;

use Orrison\MeliorStan\Rules\DepthOfInheritance\DepthOfInheritanceRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DepthOfInheritanceRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testNoErrorsUnderDefault(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/Level0.php',
                __DIR__ . '/Fixture/Level1.php',
                __DIR__ . '/Fixture/Level2.php',
                __DIR__ . '/Fixture/Level3.php',
                __DIR__ . '/Fixture/Level4.php',
                __DIR__ . '/Fixture/Level5.php',
                __DIR__ . '/Fixture/Level6.php',
                __DIR__ . '/Fixture/ShallowChild.php',
            ],
            []
        );
    }

    public function testErrorsWhenExceedingDefault(): void
    {
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
                    sprintf(DepthOfInheritanceRule::ERROR_MESSAGE_TEMPLATE, 'Level7', 7, 6),
                    5,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DepthOfInheritanceRule::class);
    }
}
