<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortMethodName;

use Orrison\MeliorStan\Rules\ShortMethodName\ShortMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortMethodNameRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Method name "a" is shorter than minimum length of 3 characters.', 7],
            ['Method name "ab" is shorter than minimum length of 3 characters.', 10],
            ['Method name "x" is shorter than minimum length of 3 characters.', 19],
            ['Method name "is" is shorter than minimum length of 3 characters.', 22],
            ['Method name "z" is shorter than minimum length of 3 characters.', 31],
            ['Method name "cd" is shorter than minimum length of 3 characters.', 37],
            ['Method name "b" is shorter than minimum length of 3 characters.', 43],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/default_options.neon',
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortMethodNameRule::class);
    }
}
