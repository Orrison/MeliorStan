<?php

namespace Orrison\MeliorStan\Tests\Rules\NumberOfChildren;

use Orrison\MeliorStan\Rules\NumberOfChildren\ClassDeclarationCollector;
use Orrison\MeliorStan\Rules\NumberOfChildren\NumberOfChildrenCollector;
use Orrison\MeliorStan\Rules\NumberOfChildren\NumberOfChildrenRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NumberOfChildrenRule>
 */
class MaximumOneTest extends RuleTestCase
{
    public function testRuleWithMaximumOne(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/AllClasses.php',
        ], [
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\ParentWithThreeChildren', 3, 1), 5],
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\GrandParent', 2, 1), 19],
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\Parent1', 2, 1), 21],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/maximum-one.neon',
        ];
    }

    protected function getCollectors(): array
    {
        return [
            self::getContainer()->getByType(NumberOfChildrenCollector::class),
            self::getContainer()->getByType(ClassDeclarationCollector::class),
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(NumberOfChildrenRule::class);
    }
}
