<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity;

use Orrison\MeliorStan\Rules\CyclomaticComplexity\CyclomaticComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CyclomaticComplexityRule>
 */
class CyclomaticComplexityRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LowComplexityClass.php',
                __DIR__ . '/Fixture/HighComplexityClass.php',
                __DIR__ . '/Fixture/VeryHighAverageComplexity.php',
                __DIR__ . '/Fixture/HighComplexityTrait.php',
                __DIR__ . '/Fixture/CatchAndLogicalOperators.php',
            ],
            [
                // HighComplexityClass::methodWithComplexityEleven (complexity 11)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithComplexityEleven', 11, 10),
                    36,
                ],
                // HighComplexityClass::veryComplexMethod (complexity 15)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'veryComplexMethod', 15, 10),
                    68,
                ],
                // HighComplexityClass class average (12.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'HighComplexityClass', 12.00, 10),
                    5,
                ],
                // VeryHighAverageComplexity::complexMethodOne (complexity 12)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodOne', 12, 10),
                    9,
                ],
                // VeryHighAverageComplexity::complexMethodTwo (complexity 12)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodTwo', 12, 10),
                    41,
                ],
                // VeryHighAverageComplexity class average (12.00)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'VeryHighAverageComplexity', 12.00, 10),
                    6,
                ],
                // HighComplexityTrait::traitComplexMethod (complexity 11)
                [
                    sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'traitComplexMethod', 11, 10),
                    9,
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
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CyclomaticComplexityRule::class);
    }
}
