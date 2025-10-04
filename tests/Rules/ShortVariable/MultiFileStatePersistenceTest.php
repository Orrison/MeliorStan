<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class MultiFileStatePersistenceTest extends RuleTestCase
{
    public function testMultipleFilesStatePersistence(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/FirstFile.php',
            __DIR__ . '/Fixture/SecondFile.php',
            __DIR__ . '/Fixture/ThirdFile.php',
        ], [
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 11],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 7],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'x', 3), 9],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 7],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'x', 3), 8],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'k', 3), 16],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'v', 3), 17],
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
