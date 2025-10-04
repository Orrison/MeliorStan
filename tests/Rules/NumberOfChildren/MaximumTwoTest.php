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
class MaximumTwoTest extends RuleTestCase
{
    public function testRuleWithMaximumTwo(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/AllClasses.php',
        ], [
            [sprintf(NumberOfChildrenRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture\ParentWithThreeChildren', 3, 2), 5],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/maximum-two.neon',
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
