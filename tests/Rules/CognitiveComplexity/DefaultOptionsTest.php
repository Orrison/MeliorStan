<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity;

use Orrison\MeliorStan\Rules\CognitiveComplexity\CognitiveComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CognitiveComplexityRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testHighlyNestedExceedsDefaultThreshold(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/DeeplyNestedClass.php'],
            [
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'process', 21, 15),
                    7,
                ],
            ]
        );
    }

    public function testLinearIfsBelowDefaultThreshold(): void
    {
        $this->analyse([__DIR__ . '/Fixture/LinearIfsClass.php'], []);
    }

    public function testNestedFiveDeepAtDefaultThreshold(): void
    {
        $this->analyse([__DIR__ . '/Fixture/NestedIfsClass.php'], []);
    }

    public function testShorthandOperatorsAreIgnored(): void
    {
        $this->analyse([__DIR__ . '/Fixture/IgnoredShorthandClass.php'], []);
    }

    public function testStandaloneFunctionExceedsDefaultThreshold(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighCognitiveFunction.php'],
            [
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'function', 'processNested', 21, 15),
                    6,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CognitiveComplexityRule::class);
    }
}
