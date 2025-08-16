<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
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
            ['Variable name "$b" is shorter than minimum length of 5 characters.', 17],
            ['Variable name "$cd" is shorter than minimum length of 5 characters.', 18],
            ['Variable name "$i" is shorter than minimum length of 5 characters.', 21],
            ['Variable name "$j" is shorter than minimum length of 5 characters.', 22],
            ['Variable name "$k" is shorter than minimum length of 5 characters.', 27],
            ['Variable name "$v" is shorter than minimum length of 5 characters.', 27],
            ['Variable name "$temp" is shorter than minimum length of 5 characters.', 28],
            ['Variable name "$e" is shorter than minimum length of 5 characters.', 33],
            ['Variable name "$msg" is shorter than minimum length of 5 characters.', 34],
            ['Parameter name "$x" is shorter than minimum length of 5 characters.', 38],
            ['Parameter name "$y" is shorter than minimum length of 5 characters.', 38],
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
