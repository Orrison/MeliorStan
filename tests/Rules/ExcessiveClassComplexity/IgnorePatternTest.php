<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity;

use Orrison\MeliorStan\Rules\ExcessiveClassComplexity\ExcessiveClassComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassComplexityRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testClassMatchingPatternIsSkipped(): void
    {
        $this->analyse([__DIR__ . '/Fixture/IgnoredService.php'], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore_pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassComplexityRule::class);
    }
}
