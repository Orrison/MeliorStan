<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects;

use Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CouplingBetweenObjectsRule>
 */
class CountAttributesEnabledTest extends RuleTestCase
{
    public function testRule(): void
    {
        // AttributeCouplingClass has 3 code deps (DepA, DepB, DepC) + 2 attributes
        // (SomeAttribute, AnotherAttribute) = 5 total.
        // With maximum=3 and count_attributes=true (default), triggers error.
        $this->analyse(
            [
                __DIR__ . '/Fixture/AttributeCouplingClass.php',
            ],
            [
                [
                    sprintf(CouplingBetweenObjectsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'AttributeCouplingClass', 5, 3),
                    11,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_maximum.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CouplingBetweenObjectsRule::class);
    }
}
