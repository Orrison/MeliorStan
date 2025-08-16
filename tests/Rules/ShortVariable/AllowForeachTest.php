<?php

namespace Orrison\MessStan\Tests\Rules\ShortVariable;

use Orrison\MessStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class AllowForeachTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClassForeachAllowed.php',
        ], [
            ['Property name "$x" is shorter than minimum length of 3 characters.', 9],
            ['Parameter name "$a" is shorter than minimum length of 3 characters.', 11],
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 13],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 15],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 16],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 27],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_foreach.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
