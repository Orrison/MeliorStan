<?php

namespace Orrison\MeliorStan\Tests\Rules\CyclomaticComplexity;

use Orrison\MeliorStan\Rules\CyclomaticComplexity\CyclomaticComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CyclomaticComplexityRule>
 */
class MethodsOnlyTest extends RuleTestCase
{
    public function testRule(): void
    {
        // With show_classes_complexity: false, only method errors should appear
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            // HighComplexityClass::methodWithComplexityEleven (complexity 11)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'methodWithComplexityEleven', 11, 10),
                74,
            ],
            // HighComplexityClass::veryComplexMethod (complexity 15)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'veryComplexMethod', 15, 10),
                106,
            ],
            // VeryHighAverageComplexity::complexMethodOne (complexity 12)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodOne', 12, 10),
                156,
            ],
            // VeryHighAverageComplexity::complexMethodTwo (complexity 12)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'complexMethodTwo', 12, 10),
                188,
            ],
            // HighComplexityTrait::traitComplexMethod (complexity 11)
            [
                sprintf(CyclomaticComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'traitComplexMethod', 11, 10),
                224,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/methods_only.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CyclomaticComplexityRule::class);
    }
}
