<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortMethodName;

use Orrison\MessedUpPhpstan\Rules\ShortMethodName\ShortMethodNameRule;
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
            ['Method name "a" is shorter than minimum length of 3 characters.', 9],
            ['Method name "ab" is shorter than minimum length of 3 characters.', 12],
            ['Method name "x" is shorter than minimum length of 3 characters.', 21],
            ['Method name "is" is shorter than minimum length of 3 characters.', 24],
            ['Method name "z" is shorter than minimum length of 3 characters.', 33],
            ['Method name "cd" is shorter than minimum length of 3 characters.', 39],
            ['Method name "b" is shorter than minimum length of 3 characters.', 45],
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
