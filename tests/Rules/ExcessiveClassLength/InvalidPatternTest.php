<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassLength;

use InvalidArgumentException;
use Orrison\MeliorStan\Rules\ExcessiveClassLength\ExcessiveClassLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassLengthRule>
 */
class InvalidPatternTest extends RuleTestCase
{
    public function testInvalidPattern(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid regex pattern in ignore_pattern configuration');

        $this->analyse([
            __DIR__ . '/Fixture/LongClass.php',
        ], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/invalid-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassLengthRule::class);
    }
}
