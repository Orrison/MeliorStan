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
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 11],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 19],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 20],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 28],
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
