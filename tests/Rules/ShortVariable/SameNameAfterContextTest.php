<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortVariable;

use Orrison\MessedUpPhpstan\Rules\ShortVariable\ShortVariableRule;
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
            // These should be violations since they're defined AFTER the allowed contexts
            ['Variable name "$i" is shorter than minimum length of 3 characters.', 13],
            ['Variable name "$k" is shorter than minimum length of 3 characters.', 22],
            ['Variable name "$v" is shorter than minimum length of 3 characters.', 23],
            ['Variable name "$e" is shorter than minimum length of 3 characters.', 33],
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
