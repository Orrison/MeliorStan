<?php

namespace Orrison\MeliorStan\Tests\Rules\TraitConstantNamingConventions;

use Orrison\MeliorStan\Rules\TraitConstantNamingConventions\TraitConstantNamingConventionsRule;
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
            [sprintf(TraitConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'traitConstant'), 15],
            [sprintf(TraitConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'maxRetries'), 17],
            [sprintf(TraitConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'mixedCase'), 19],
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
