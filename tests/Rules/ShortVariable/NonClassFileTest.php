<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class NonClassFileTest extends RuleTestCase
{
    public function testNonClassFile(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/NonClassFile.php',
        ], [
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 9],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 17],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 18],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 29],
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 32],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 33],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_all_contexts.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
