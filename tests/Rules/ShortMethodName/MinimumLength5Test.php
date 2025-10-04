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
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'a', 5), 7],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'ab', 5), 10],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'abc', 5), 13],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'abcd', 5), 16],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'x', 5), 19],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'is', 5), 22],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'get', 5), 25],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'z', 5), 31],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'xyz', 5), 34],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'cd', 5), 37],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'efg', 5), 40],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'b', 5), 43],
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
