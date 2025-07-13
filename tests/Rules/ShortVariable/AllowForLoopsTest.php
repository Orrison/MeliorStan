<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class AllowForLoopsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClassForLoopsAllowed.php',
        ], [
            ['Property name "$x" is shorter than minimum length of 3 characters.', 9],
            ['Parameter name "$a" is shorter than minimum length of 3 characters.', 11],
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 14],
            // $i should NOT be flagged in for loop when allow_in_for_loops is true
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 18],
            // foreach variables should still be flagged when only allow_in_for_loops is true
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 23],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 23],
            // catch variables should still be flagged when only allow_in_for_loops is true
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 30],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_for_loops.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
