<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class SameNameAfterContextTest extends RuleTestCase
{
    public function testSameNameAfterAllowedContexts(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/SameNameAfterContext.php',
        ], [
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 11],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'k', 3), 19],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'v', 3), 20],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'e', 3), 28],
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
