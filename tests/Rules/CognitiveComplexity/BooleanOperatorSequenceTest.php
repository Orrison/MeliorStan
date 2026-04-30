<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity;

use Orrison\MeliorStan\Rules\CognitiveComplexity\CognitiveComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CognitiveComplexityRule>
 */
class BooleanOperatorSequenceTest extends RuleTestCase
{
    public function testBooleanRunsAreCountedPerSequence(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/BooleanSequenceClass.php'],
            [
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'singleAndRun', 2, 1),
                    7,
                ],
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'mixedRuns', 4, 1),
                    16,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/low_method_threshold.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CognitiveComplexityRule::class);
    }
}
