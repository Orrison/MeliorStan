<?php

namespace Orrison\MeliorStan\Tests\Rules\DepthOfInheritance;

use Orrison\MeliorStan\Rules\DepthOfInheritance\DepthOfInheritanceRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DepthOfInheritanceRule>
 */
class ExcludedNamespacesTest extends RuleTestCase
{
    public function testVendorAncestorsDoNotCount(): void
    {
        // UserExtendsVendor extends FrameworkTop -> FrameworkMiddle -> FrameworkBase
        // Without exclusions: depth = 4 (FrameworkTop, FrameworkMiddle, FrameworkBase = 3 vendor + 0 user ancestors)
        // Wait — UserExtendsVendor has no user ancestors, just vendor ones.
        // With vendor namespace excluded: depth = 0 (all ancestors are vendor)
        // UserExtendsVendorDeep extends UserExtendsVendor -> FrameworkTop -> FrameworkMiddle -> FrameworkBase
        // With vendor namespace excluded: depth = 1 (only UserExtendsVendor counts)
        // Maximum is 3, so neither should error.
        $this->analyse(
            [
                __DIR__ . '/Fixture/Vendor/FrameworkBase.php',
                __DIR__ . '/Fixture/Vendor/FrameworkMiddle.php',
                __DIR__ . '/Fixture/Vendor/FrameworkTop.php',
                __DIR__ . '/Fixture/UserExtendsVendor.php',
                __DIR__ . '/Fixture/UserExtendsVendorDeep.php',
            ],
            []
        );
    }

    public function testWithoutExclusionsWouldError(): void
    {
        // This test proves that without exclusions at max 3, Level4 (depth 4) would error.
        // But we're using excluded-namespaces config which has max 3 AND vendor exclusion.
        // Level4 has no vendor ancestors, so it still errors.
        $this->analyse(
            [
                __DIR__ . '/Fixture/Level0.php',
                __DIR__ . '/Fixture/Level1.php',
                __DIR__ . '/Fixture/Level2.php',
                __DIR__ . '/Fixture/Level3.php',
                __DIR__ . '/Fixture/Level4.php',
            ],
            [
                [
                    sprintf(DepthOfInheritanceRule::ERROR_MESSAGE_TEMPLATE, 'Level4', 4, 3),
                    5,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/excluded-namespaces.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DepthOfInheritanceRule::class);
    }
}
