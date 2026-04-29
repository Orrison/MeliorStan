<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity;

use Orrison\MeliorStan\Rules\NpathComplexity\NpathComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NpathComplexityRule>
 */
class CustomThresholdTest extends RuleTestCase
{
    public function testMethodExceedingCustomThresholdTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/MediumNpathClass.php'],
            [
                [
                    sprintf(NpathComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Method', 'moderateMethod', 64, 32),
                    8,
                ],
            ]
        );
    }

    public function testMethodUnderCustomThresholdNoError(): void
    {
        $this->analyse([__DIR__ . '/Fixture/LowNpathClass.php'], []);
    }

    public function testHighNpathMethodAlsoTriggersWithCustomThreshold(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighNpathClass.php'],
            [
                [
                    sprintf(NpathComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Method', 'processOrder', 256, 32),
                    8,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_threshold.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(NpathComplexityRule::class);
    }
}
