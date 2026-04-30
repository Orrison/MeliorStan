<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity;

use Orrison\MeliorStan\Rules\CognitiveComplexity\CognitiveComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CognitiveComplexityRule>
 */
class NestingPenaltyTest extends RuleTestCase
{
    public function testFiveLinearIfsScoreFive(): void
    {
        $this->analyse([__DIR__ . '/Fixture/LinearIfsClass.php'], []);
    }

    public function testFiveNestedIfsScoreFifteen(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/NestedIfsClass.php'],
            [
                [
                    sprintf(CognitiveComplexityRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'method', 'process', 15, 6),
                    7,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/nesting_penalty.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CognitiveComplexityRule::class);
    }
}
