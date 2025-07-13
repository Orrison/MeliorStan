<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortVariableRule>
 */
class PureProceduralFileTest extends RuleTestCase
{
    public function testPureProceduralFile(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/PureProceduralFile.php',
        ], [
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 5], // Before for loop
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 11], // After for loop  
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 13], // Regular variable
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
