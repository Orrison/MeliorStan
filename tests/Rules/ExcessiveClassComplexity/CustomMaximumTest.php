<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity;

use Orrison\MeliorStan\Rules\ExcessiveClassComplexity\ExcessiveClassComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassComplexityRule>
 */
class CustomMaximumTest extends RuleTestCase
{
    public function testClassExceedingCustomMaximumTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/SmallMaxClass.php'],
            [
                [
                    sprintf(ExcessiveClassComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Class "SmallMaxClass"', 6, 5),
                    5,
                ],
            ]
        );
    }

    public function testHighComplexityInterfaceTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighComplexityInterface.php'],
            [
                [
                    sprintf(ExcessiveClassComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Interface "HighComplexityInterface"', 6, 5),
                    5,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_maximum.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassComplexityRule::class);
    }
}
