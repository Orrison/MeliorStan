<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity;

use Orrison\MeliorStan\Rules\NpathComplexity\NpathComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NpathComplexityRule>
 */
class OverflowTest extends RuleTestCase
{
    public function testMethodWithOverflowingNpathUsesOverflowMessage(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/OverflowNpathClass.php'],
            [
                [
                    sprintf(NpathComplexityRule::ERROR_MESSAGE_OVERFLOW, 'Method', 'overflowMethod', 200),
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
