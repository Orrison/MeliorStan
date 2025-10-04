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
class DefaultOptionsTest extends RuleTestCase
{
    public function testRuleWithDefaultMaximum(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/AllClasses.php',
        ], [
            // With default maximum of 15, none should trigger
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/default.neon',
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
