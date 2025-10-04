<?php

namespace Orrison\MeliorStan\Tests\Rules\ShortVariable;

use Orrison\MeliorStan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class MultipleProceduralFilesTest extends RuleTestCase
{
    public function testMultipleProceduralFiles(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/FirstProceduralFile.php',
            __DIR__ . '/Fixture/SecondProceduralFile.php',
        ], [
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 5],
            [sprintf(ShortVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'i', 3), 3],
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
