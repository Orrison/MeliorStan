<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
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
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 11],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 7],
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 9],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 7],
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 8],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 16],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 17],
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
