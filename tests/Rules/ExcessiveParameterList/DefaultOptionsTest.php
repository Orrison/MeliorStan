<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveParameterList;

use Orrison\MeliorStan\Rules\ExcessiveParameterList\ExcessiveParameterListRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveParameterListRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testClassMethodTriggers(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ManyParamMethod.php'],
            [
                [
                    sprintf(ExcessiveParameterListRule::ERROR_MESSAGE_TEMPLATE, 'Method "tooManyParams"', 4, 3),
                    7,
                ],
            ]
        );
    }

    public function testFewParamsNoError(): void
    {
        $this->analyse([__DIR__ . '/Fixture/FewParamMethod.php'], []);
    }

    public function testStandaloneFunctionTriggers(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ManyParamFunction.php'],
            [
                [
                    sprintf(ExcessiveParameterListRule::ERROR_MESSAGE_TEMPLATE, 'Function "manyParamFunction"', 4, 3),
                    5,
                ],
            ]
        );
    }

    public function testClosureTriggers(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ManyParamClosure.php'],
            [
                [
                    sprintf(ExcessiveParameterListRule::ERROR_MESSAGE_TEMPLATE, 'Closure', 4, 3),
                    5,
                ],
            ]
        );
    }

    public function testArrowFunctionTriggers(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ManyParamArrowFunction.php'],
            [
                [
                    sprintf(ExcessiveParameterListRule::ERROR_MESSAGE_TEMPLATE, 'Arrow function', 4, 3),
                    5,
                ],
            ]
        );
    }

    public function testAbstractMethodTriggers(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/AbstractMethodManyParams.php'],
            [
                [
                    sprintf(ExcessiveParameterListRule::ERROR_MESSAGE_TEMPLATE, 'Method "tooManyParams"', 4, 3),
                    7,
                ],
            ]
        );
    }

    public function testInterfaceMethodTriggers(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/InterfaceManyParams.php'],
            [
                [
                    sprintf(ExcessiveParameterListRule::ERROR_MESSAGE_TEMPLATE, 'Method "tooManyParams"', 4, 3),
                    7,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveParameterListRule::class);
    }
}
