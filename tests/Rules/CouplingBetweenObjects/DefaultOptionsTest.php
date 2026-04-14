<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects;

use Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CouplingBetweenObjectsRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/HighCouplingClass.php',
                __DIR__ . '/Fixture/LowCouplingClass.php',
                __DIR__ . '/Fixture/DeduplicationClass.php',
            ],
            [
                [
                    sprintf(CouplingBetweenObjectsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'HighCouplingClass', 14, 13),
                    20,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CouplingBetweenObjectsRule::class);
    }
}
