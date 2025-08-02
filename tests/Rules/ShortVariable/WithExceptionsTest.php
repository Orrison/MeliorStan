<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class WithExceptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Property name "$id" is shorter than minimum length of 3 characters.', 11],
            ['Parameter name "$a" is shorter than minimum length of 3 characters.', 15],
            ['Parameter name "$id" is shorter than minimum length of 3 characters.', 15],
            ['Variable name "$b" is shorter than minimum length of 3 characters.', 17],
            ['Variable name "$cd" is shorter than minimum length of 3 characters.', 18],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 27],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/with_exceptions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
