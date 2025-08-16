<?php

namespace Orrison\MessStan\Tests\Rules\ShortVariable;

use Orrison\MessStan\Rules\ShortVariable\ShortVariableRule;
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
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 5],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 3],
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
