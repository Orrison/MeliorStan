<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use InvalidArgumentException;
use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class InvalidPropertyPatternTest extends RuleTestCase
{
    public function testInvalidPropertyPattern(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid regex pattern in property_ignore_pattern configuration');

        $this->analyse([
            __DIR__ . '/Fixture/StaticPropertyAccessExample.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/invalid-property-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
