<?php

namespace Orrison\MeliorStan\Tests\Rules\NumberOfChildren;

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
            __DIR__ . '/Fixture/ParentWithThreeChildren.php',
            __DIR__ . '/Fixture/ChildOne.php',
            __DIR__ . '/Fixture/ChildTwo.php',
            __DIR__ . '/Fixture/ChildThree.php',
            __DIR__ . '/Fixture/ParentWithOneChild.php',
            __DIR__ . '/Fixture/OnlyChild.php',
            __DIR__ . '/Fixture/ParentWithNoChildren.php',
            __DIR__ . '/Fixture/GrandParent.php',
            __DIR__ . '/Fixture/Parent1.php',
            __DIR__ . '/Fixture/Parent2.php',
            __DIR__ . '/Fixture/GrandChild1.php',
            __DIR__ . '/Fixture/GrandChild2.php',
        ], [
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\ParentWithThreeChildren', 3, 1), 5],
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\GrandParent', 2, 1), 5],
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\Parent1', 2, 1), 5],
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
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(NumberOfChildrenRule::class);
    }
}
