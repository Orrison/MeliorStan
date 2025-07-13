<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class AllowCatchTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClassCatchAllowed.php',
        ], [
            ['Property name "$x" is shorter than minimum length of 3 characters.', 9],
            ['Parameter name "$a" is shorter than minimum length of 3 characters.', 11],
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 14],
            // for loop variables should still be flagged when only allow_in_catch is true
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 17],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 17],
            ['Variable name "$j" is shorter than minimum length of 3 characters.', 18],
            // foreach variables should still be flagged when only allow_in_catch is true
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 23],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 23],
            // $e should NOT be flagged in catch when allow_in_catch is true
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_catch.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
