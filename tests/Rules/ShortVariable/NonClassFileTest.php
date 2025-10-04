<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class NonClassFileTest extends RuleTestCase
{
    public function testNonClassFile(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/NonClassFile.php',
        ], [
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 9],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'k', 3), 17],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'v', 3), 18],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'e', 3), 29],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'x', 3), 32],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'j', 3), 33],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_all_contexts.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortVariableRule::class);
    }
}
