<?php

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
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 3],
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 9],
            ['Variable name "$x" is shorter than minimum length of 3 characters.', 11],
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
