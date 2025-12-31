<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity;

use Orrison\MeliorStan\Rules\CyclomaticComplexity\CyclomaticComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CyclomaticComplexityRule>
 */
class CustomThresholdTest extends RuleTestCase
{
    public function testRule(): void
    {
        // With report_level: 5, more methods should be flagged
        $this->analyse(
            [
                __DIR__ . '/Fixture/LowComplexityClass.php',
                __DIR__ . '/Fixture/HighComplexityClass.php',
                __DIR__ . '/Fixture/VeryHighAverageComplexity.php',
                __DIR__ . '/Fixture/HighComplexityTrait.php',
                __DIR__ . '/Fixture/CatchAndLogicalOperators.php',
            ],
            [
                // HighComplexityClass::methodWithComplexityTen (complexity 10)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithComplexityTen', 10, 5),
                    8,
                ],
                // HighComplexityClass::methodWithComplexityEleven (complexity 11)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithComplexityEleven', 11, 5),
                    36,
                ],
                // HighComplexityClass::veryComplexMethod (complexity 15)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'veryComplexMethod', 15, 5),
                    68,
                ],
                // HighComplexityClass class average (12.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'HighComplexityClass', 12.00, 5),
                    5,
                ],
                // VeryHighAverageComplexity::complexMethodOne (complexity 12)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodOne', 12, 5),
                    9,
                ],
                // VeryHighAverageComplexity::complexMethodTwo (complexity 12)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodTwo', 12, 5),
                    41,
                ],
                // VeryHighAverageComplexity class average (12.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'VeryHighAverageComplexity', 12.00, 5),
                    6,
                ],
                // HighComplexityTrait::traitComplexMethod (complexity 11)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'traitComplexMethod', 11, 5),
                    9,
                ],
                // HighComplexityTrait class average (11.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'trait', 'HighComplexityTrait', 11.00, 5),
                    6,
                ],
                // CatchAndLogicalOperators::methodWithCatchBlocks (complexity 7)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithCatchBlocks', 7, 5),
                    12,
                ],
                // CatchAndLogicalOperators class average (7.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'CatchAndLogicalOperators', 7.00, 5),
                    9,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_threshold.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CyclomaticComplexityRule::class);
    }
}
