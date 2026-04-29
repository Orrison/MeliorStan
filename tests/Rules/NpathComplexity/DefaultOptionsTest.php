<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity;

use Orrison\MeliorStan\Rules\NpathComplexity\NpathComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NpathComplexityRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testHighNpathMethodTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighNpathClass.php'],
            [
                [
                    sprintf(NpathComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Method', 'processOrder', 256, 200),
                    8,
                ],
            ]
        );
    }

    public function testLowNpathMethodNoError(): void
    {
        $this->analyse([__DIR__ . '/Fixture/LowNpathClass.php'], []);
    }

    public function testHighNpathFunctionTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighNpathFunction.php'],
            [
                [
                    sprintf(NpathComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Function', 'processData', 256, 200),
                    6,
                ],
            ]
        );
    }

    public function testMatchExpressionContributesToNpath(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/MatchExpressionClass.php'],
            [
                [
                    sprintf(NpathComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Method', 'processWithMatch', 2304, 200),
                    8,
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
        return self::getContainer()->getByType(NpathComplexityRule::class);
    }
}
