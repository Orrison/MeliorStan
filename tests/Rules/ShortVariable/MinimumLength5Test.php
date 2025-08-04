<?php

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
            ['Variable name "$b" is shorter than minimum length of 5 characters.', 17],
            ['Variable name "$cd" is shorter than minimum length of 5 characters.', 18],
            ['Variable name "$i" is shorter than minimum length of 5 characters.', 21],
            ['Variable name "$i" is shorter than minimum length of 5 characters.', 21],
            ['Variable name "$j" is shorter than minimum length of 5 characters.', 22],
            ['Variable name "$k" is shorter than minimum length of 5 characters.', 27],
            ['Variable name "$v" is shorter than minimum length of 5 characters.', 27],
            ['Variable name "$temp" is shorter than minimum length of 5 characters.', 28],
            ['Variable name "$e" is shorter than minimum length of 5 characters.', 33],
            ['Variable name "$msg" is shorter than minimum length of 5 characters.', 34],
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
