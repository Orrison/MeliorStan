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
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'a', 3), 7],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'ab', 3), 10],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'x', 3), 19],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'is', 3), 22],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'z', 3), 31],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'cd', 3), 37],
            [sprintf(ShortMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'b', 3), 43],
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
