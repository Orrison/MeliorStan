<?php

declare(strict_types = 1);

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
            // Variables after allowed contexts should be violations
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 13],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 23],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 24],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 36],
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 40],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 41],
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
