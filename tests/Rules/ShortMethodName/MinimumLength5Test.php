<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortMethodName;

use Orrison\MeliorStan\Rules\ShortMethodName\ShortMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortMethodNameRule>
 */
class MinimumLength5Test extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Method name "a" is shorter than minimum length of 5 characters.', 7],
            ['Method name "ab" is shorter than minimum length of 5 characters.', 10],
            ['Method name "abc" is shorter than minimum length of 5 characters.', 13],
            ['Method name "abcd" is shorter than minimum length of 5 characters.', 16],
            ['Method name "x" is shorter than minimum length of 5 characters.', 19],
            ['Method name "is" is shorter than minimum length of 5 characters.', 22],
            ['Method name "get" is shorter than minimum length of 5 characters.', 25],
            ['Method name "z" is shorter than minimum length of 5 characters.', 31],
            ['Method name "xyz" is shorter than minimum length of 5 characters.', 34],
            ['Method name "cd" is shorter than minimum length of 5 characters.', 37],
            ['Method name "efg" is shorter than minimum length of 5 characters.', 40],
            ['Method name "b" is shorter than minimum length of 5 characters.', 43],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/minimum_length_5.neon',
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortMethodNameRule::class);
    }
}
