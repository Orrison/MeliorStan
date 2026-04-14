<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects;

use Orrison\MeliorStan\Rules\CouplingBetweenObjects\CouplingBetweenObjectsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CouplingBetweenObjectsRule>
 */
class CustomMaximumTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/CustomMaximumHighClass.php',
                __DIR__ . '/Fixture/CustomMaximumLowClass.php',
            ],
            [
                [
                    sprintf(CouplingBetweenObjectsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'CustomMaximumHighClass', 4, 3),
                    10,
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
