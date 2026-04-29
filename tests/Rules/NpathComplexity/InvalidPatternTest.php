<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity;

use InvalidArgumentException;
use Orrison\MeliorStan\Rules\NpathComplexity\NpathComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NpathComplexityRule>
 */
class InvalidPatternTest extends RuleTestCase
{
    public function testInvalidPattern(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid regex pattern in ignore_pattern configuration');

        $this->analyse([
            __DIR__ . '/Fixture/HighNpathClass.php',
        ], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/invalid_pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(NpathComplexityRule::class);
    }
}
