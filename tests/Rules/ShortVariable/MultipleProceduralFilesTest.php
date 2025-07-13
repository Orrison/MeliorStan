<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
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
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 6], // First file after for
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 5], // Second file - might be missing without reset
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
