<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects;

use Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CouplingBetweenObjectsRule>
 */
class ExcludedTypesTest extends RuleTestCase
{
    public function testRule(): void
    {
        // ExcludedTypesClass has 4 deps (DepA-D). With DepA excluded and maximum=3,
        // only 3 remain (DepB, DepC, DepD) -> should pass.
        $this->analyse(
            [
                __DIR__ . '/Fixture/ExcludedTypesClass.php',
            ],
            []
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/excluded_types.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CouplingBetweenObjectsRule::class);
    }
}
