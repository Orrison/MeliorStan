<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassLength;

use Orrison\MeliorStan\Rules\ExcessiveClassLength\ExcessiveClassLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassLengthRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testIgnoredClassNamesAreSkipped(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/PatternMatchedClass.php',
                __DIR__ . '/Fixture/LongClass.php',
            ],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Class "LongClass"', 14, 5),
                    5,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassLengthRule::class);
    }
}
