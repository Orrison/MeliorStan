<?php

declare(strict_types=1);

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
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 18],
            ['Variable name "$cd" is shorter than minimum length of 3 characters.', 19],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 23],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 23],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 24],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 30],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 30],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 37],
            ['Parameter name "$x" is shorter than minimum length of 3 characters.', 42],
            ['Parameter name "$y" is shorter than minimum length of 3 characters.', 42],
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 44],
            ['Variable name "$y" is shorter than minimum length of 3 characters.', 44],
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
