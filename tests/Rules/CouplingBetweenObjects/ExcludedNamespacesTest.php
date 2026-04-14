<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects;

use Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CouplingBetweenObjectsRule>
 */
class ExcludedNamespacesTest extends RuleTestCase
{
    public function testRule(): void
    {
        // ExcludedNamespacesClass has 4 non-excluded deps (DepA-D) + 2 excluded deps.
        // With maximum=3 and excluded namespace, only the 4 non-excluded count -> triggers error.
        $this->analyse(
            [
                __DIR__ . '/Fixture/ExcludedNamespacesClass.php',
            ],
            [
                [
                    sprintf(CouplingBetweenObjectsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ExcludedNamespacesClass', 4, 3),
                    12,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/excluded_namespaces.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CouplingBetweenObjectsRule::class);
    }
}
