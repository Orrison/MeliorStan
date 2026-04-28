<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveParameterList;

use Orrison\MeliorStan\Rules\ExcessiveParameterList\ExcessiveParameterListRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveParameterListRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testIgnoredMethodSkipped(): void
    {
        $this->analyse([__DIR__ . '/Fixture/IgnoredMethodByPattern.php'], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore_pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveParameterListRule::class);
    }
}
