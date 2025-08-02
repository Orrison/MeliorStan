<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortMethodName;

use Orrison\MessedUpPhpstan\Rules\ShortMethodName\ShortMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortMethodNameRule>
 */
class WithExceptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Method name "ab" is shorter than minimum length of 3 characters.', 10],
            ['Method name "x" is shorter than minimum length of 3 characters.', 19],
            ['Method name "z" is shorter than minimum length of 3 characters.', 31],
            ['Method name "cd" is shorter than minimum length of 3 characters.', 37],
            ['Method name "b" is shorter than minimum length of 3 characters.', 43],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/with_exceptions.neon',
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortMethodNameRule::class);
    }
}
