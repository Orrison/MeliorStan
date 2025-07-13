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
            // FirstFile.php violations
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 13], // After for loop
            
            // SecondFile.php violations - if state persists incorrectly, these might be missing
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 9], // Regular assignment
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 12], // Regular assignment
            
            // ThirdFile.php violations  
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 8], // Regular assignment
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 9], // Regular assignment
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 18], // After foreach
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 19], // After foreach
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
