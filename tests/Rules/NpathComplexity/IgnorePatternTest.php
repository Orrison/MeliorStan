<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity;

use Orrison\MeliorStan\Rules\NpathComplexity\NpathComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NpathComplexityRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testMethodMatchingPatternIsSkipped(): void
    {
        $this->analyse([__DIR__ . '/Fixture/IgnoredMethodClass.php'], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore_pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(NpathComplexityRule::class);
    }
}
