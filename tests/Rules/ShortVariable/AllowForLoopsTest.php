<?php

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
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 13],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 16],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 21],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 21],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 27],
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
