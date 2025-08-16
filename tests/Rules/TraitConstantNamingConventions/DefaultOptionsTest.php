<?php

namespace Orrison\MessStan\Tests\Rules\TraitConstantNamingConventions;

use Orrison\MessStan\Rules\TraitConstantNamingConventions\TraitConstantNamingConventionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TraitConstantNamingConventionsRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testTraitConstants(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleTrait.php',
        ], [
            ['Constant name "traitConstant" is not in UPPERCASE.', 15],
            ['Constant name "maxRetries" is not in UPPERCASE.', 17],
            ['Constant name "mixedCase" is not in UPPERCASE.', 19],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TraitConstantNamingConventionsRule::class);
    }
}
