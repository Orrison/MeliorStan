<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use InvalidArgumentException;
use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class InvalidPatternTest extends RuleTestCase
{
    public function testInvalidMethodPattern(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid regex pattern in method_ignore_pattern configuration');

        $this->analyse([
            __DIR__ . '/Fixture/IgnorePatternExample.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/invalid-method-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
