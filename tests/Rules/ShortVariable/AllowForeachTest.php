<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class AllowForeachTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClassForeachAllowed.php',
        ], [
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'x', 3), 9],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'a', 3), 11],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'b', 3), 13],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 15],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'j', 3), 16],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'e', 3), 27],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_foreach.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
