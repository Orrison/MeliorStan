<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity;

use Orrison\MeliorStan\Rules\CognitiveComplexity\CognitiveComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CognitiveComplexityRule>
 */
class ClassThresholdTest extends RuleTestCase
{
    public function testClassAggregateExceedsThreshold(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighClassTotalClass.php'],
            [
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_CLASS, 'class', 'HighClassTotalClass', 55, 50),
                    5,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/class_threshold.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CognitiveComplexityRule::class);
    }
}
