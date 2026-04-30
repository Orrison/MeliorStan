<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity;

use Orrison\MeliorStan\Rules\CognitiveComplexity\CognitiveComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CognitiveComplexityRule>
 */
class MultiLevelBreakTest extends RuleTestCase
{
    public function testMultiLevelBreakAddsIncrement(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/MultiLevelBreakClass.php'],
            [
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'search', 7, 1),
                    10,
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
