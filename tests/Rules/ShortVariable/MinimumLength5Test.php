<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class MinimumLength5Test extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Property name "$x" is shorter than minimum length of 5 characters.', 9],
            ['Property name "$id" is shorter than minimum length of 5 characters.', 11],
            ['Parameter name "$a" is shorter than minimum length of 5 characters.', 15],
            ['Parameter name "$id" is shorter than minimum length of 5 characters.', 15],
            ['Variable name "$b" is shorter than minimum length of 5 characters.', 18],
            ['Variable name "$cd" is shorter than minimum length of 5 characters.', 19],
            ['Variable name "$i" is shorter than minimum length of 5 characters.', 23],
            ['Variable name "$i" is shorter than minimum length of 5 characters.', 23],
            ['Variable name "$j" is shorter than minimum length of 5 characters.', 24],
            ['Variable name "$k" is shorter than minimum length of 5 characters.', 30],
            ['Variable name "$v" is shorter than minimum length of 5 characters.', 30],
            ['Variable name "$temp" is shorter than minimum length of 5 characters.', 31],
            ['Variable name "$e" is shorter than minimum length of 5 characters.', 37],
            ['Variable name "$msg" is shorter than minimum length of 5 characters.', 38],
            ['Parameter name "$x" is shorter than minimum length of 5 characters.', 42],
            ['Parameter name "$y" is shorter than minimum length of 5 characters.', 42],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/minimum_length_5.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
