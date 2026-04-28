<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassLength;

use Orrison\MeliorStan\Rules\ExcessiveClassLength\ExcessiveClassLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassLengthRule>
 */
class IgnoreWhitespaceTest extends RuleTestCase
{
    public function testWhitespaceAndCommentsAreIgnored(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/SparseLongClass.php',
                __DIR__ . '/Fixture/DenseLongClass.php',
            ],
            [
                [
                    sprintf(ExcessiveClassLengthRule::ERROR_MESSAGE_TEMPLATE, 'Class "DenseLongClass"', 9, 5),
                    5,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore-whitespace.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassLengthRule::class);
    }
}
