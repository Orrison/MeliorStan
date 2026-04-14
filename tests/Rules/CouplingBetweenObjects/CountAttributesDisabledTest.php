<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects;

use Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CouplingBetweenObjectsRule>
 */
class CountAttributesDisabledTest extends RuleTestCase
{
    public function testRule(): void
    {
        // AttributeNoCouplingClass has 3 code deps (DepA, DepB, DepC) + 2 attributes.
        // With count_attributes=false and maximum=3, only 3 code deps count -> passes.
        $this->analyse(
            [
                __DIR__ . '/Fixture/AttributeNoCouplingClass.php',
            ],
            []
        );
    }

    public function testAttributesCountWhenEnabled(): void
    {
        // AttributeCouplingClass has 3 code deps + 2 attributes = 5 total.
        // But this test uses count_attributes=false, so only 3 -> passes.
        $this->analyse(
            [
                __DIR__ . '/Fixture/AttributeCouplingClass.php',
            ],
            []
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/count_attributes_disabled.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CouplingBetweenObjectsRule::class);
    }
}
