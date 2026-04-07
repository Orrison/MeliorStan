<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter;

use Orrison\MeliorStan\Rules\UnusedFormalParameter\UnusedFormalParameterRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedFormalParameterRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testBasicUnused(): void
    {
        $this->analyse([__DIR__ . '/Fixture/BasicUnused.php'], [
            [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'unused'), 7],
            [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'unused'), 13],
        ]);
    }

    public function testMagicMethods(): void
    {
        $this->analyse([__DIR__ . '/Fixture/MagicMethods.php'], []);
    }

    public function testAbstractMethod(): void
    {
        $this->analyse([__DIR__ . '/Fixture/AbstractMethod.php'], []);
    }

    public function testInterfaceMethod(): void
    {
        $this->analyse([__DIR__ . '/Fixture/InterfaceMethod.php'], []);
    }

    public function testInheritDocAllowedByDefault(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/InheritDocParent.php',
                __DIR__ . '/Fixture/InheritDocChild.php',
            ],
            [],
        );
    }

    public function testOverridingMethodAllowedByDefault(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/OverridingParent.php',
                __DIR__ . '/Fixture/OverridingChild.php',
            ],
            [],
        );
    }

    public function testFuncGetArgsSuppresses(): void
    {
        $this->analyse([__DIR__ . '/Fixture/FuncGetArgs.php'], []);
    }

    public function testCompactParam(): void
    {
        $this->analyse([__DIR__ . '/Fixture/CompactParam.php'], []);
    }

    public function testPromotedConstructor(): void
    {
        $this->analyse([__DIR__ . '/Fixture/PromotedConstructor.php'], []);
    }

    public function testVariableVariableSuppresses(): void
    {
        $this->analyse([__DIR__ . '/Fixture/VariableVariable.php'], []);
    }

    public function testClosureUseInside(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ClosureUseInside.php'], []);
    }

    public function testArrowFunctionUses(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ArrowFunctionUses.php'], []);
    }

    public function testVariadic(): void
    {
        $this->analyse([__DIR__ . '/Fixture/Variadic.php'], [
            [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'values'), 12],
        ]);
    }

    public function testByReference(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ByReference.php'], [
            [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'out'), 7],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedFormalParameterRule::class);
    }
}
