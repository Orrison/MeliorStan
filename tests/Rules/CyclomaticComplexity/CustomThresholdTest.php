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
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            // HighComplexityClass::methodWithComplexityTen (complexity 10)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithComplexityTen', 10, 5),
                46,
            ],
            // HighComplexityClass::methodWithComplexityEleven (complexity 11)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithComplexityEleven', 11, 5),
                74,
            ],
            // HighComplexityClass::veryComplexMethod (complexity 15)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'veryComplexMethod', 15, 5),
                106,
            ],
            // HighComplexityClass class average (12.00)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'HighComplexityClass', 12.00, 5),
                43,
            ],
            // VeryHighAverageComplexity::complexMethodOne (complexity 12)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodOne', 12, 5),
                156,
            ],
            // VeryHighAverageComplexity::complexMethodTwo (complexity 12)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodTwo', 12, 5),
                188,
            ],
            // VeryHighAverageComplexity class average (12)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'VeryHighAverageComplexity', 12.00, 5),
                153,
            ],
            // HighComplexityTrait::traitComplexMethod (complexity 11)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'traitComplexMethod', 11, 5),
                224,
            ],
            // HighComplexityTrait class average (11)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'trait', 'HighComplexityTrait', 11.00, 5),
                221,
            ],
            // CatchAndLogicalOperators::methodWithCatchBlocks (complexity 7)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithCatchBlocks', 7, 5),
                260,
            ],
            // CatchAndLogicalOperators class average (7)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'CatchAndLogicalOperators', 7.00, 5),
                257,
            ],
        ]);
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
