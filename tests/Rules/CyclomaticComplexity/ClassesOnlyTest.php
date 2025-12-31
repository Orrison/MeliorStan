<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity;

use Orrison\MeliorStan\Rules\CyclomaticComplexity\CyclomaticComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CyclomaticComplexityRule>
 */
class ClassesOnlyTest extends RuleTestCase
{
    public function testRule(): void
    {
        // With show_methods_complexity: false, only class average errors should appear
        $this->analyse(
            [
                __DIR__ . '/Fixture/LowComplexityClass.php',
                __DIR__ . '/Fixture/HighComplexityClass.php',
                __DIR__ . '/Fixture/VeryHighAverageComplexity.php',
                __DIR__ . '/Fixture/HighComplexityTrait.php',
                __DIR__ . '/Fixture/CatchAndLogicalOperators.php',
            ],
            [
                // HighComplexityClass class average (12.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'HighComplexityClass', 12.00, 10),
                    5,
                ],
                // VeryHighAverageComplexity class average (12.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'VeryHighAverageComplexity', 12.00, 10),
                    6,
                ],
                // HighComplexityTrait class average (11.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'trait', 'HighComplexityTrait', 11.00, 10),
                    6,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/classes_only.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CyclomaticComplexityRule::class);
    }
}
