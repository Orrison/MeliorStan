<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\ConstantNamingConventions;

use Orrison\MessedUpPhpstan\Rules\ConstantNamingConventions\ConstantNamingConventionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ConstantNamingConventionsRule>
 */
class TraitConstantsTest extends RuleTestCase
{
    public function testTraitConstants(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleTrait.php',
        ], [
            ['Constant name "traitConstant" is not in UPPERCASE.', 13],
            ['Constant name "maxRetries" is not in UPPERCASE.', 15],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ConstantNamingConventionsRule::class);
    }
}
