<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Property name "$x" is shorter than minimum length of 3 characters.', 9],
            ['Property name "$id" is shorter than minimum length of 3 characters.', 11],
            ['Parameter name "$a" is shorter than minimum length of 3 characters.', 15],
            ['Parameter name "$id" is shorter than minimum length of 3 characters.', 15],
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 17],
            ['Variable name "$cd" is shorter than minimum length of 3 characters.', 18],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 21],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 22],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 27],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 27],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 33],
            ['Parameter name "$x" is shorter than minimum length of 3 characters.', 38],
            ['Parameter name "$y" is shorter than minimum length of 3 characters.', 38],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
