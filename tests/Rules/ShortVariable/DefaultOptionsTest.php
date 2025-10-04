<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'x', 3), 9],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'id', 3), 11],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'a', 3), 15],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'id', 3), 15],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'b', 3), 17],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'cd', 3), 18],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 21],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'j', 3), 22],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'k', 3), 27],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'v', 3), 27],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'e', 3), 33],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'x', 3), 38],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'y', 3), 38],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
