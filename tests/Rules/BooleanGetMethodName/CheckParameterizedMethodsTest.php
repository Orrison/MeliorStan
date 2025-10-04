<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanGetMethodName;

use Orrison\MeliorStan\Rules\BooleanGetMethodName\BooleanGetMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanGetMethodNameRule>
 */
class CheckParameterizedMethodsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getBooleanValue'), 8],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getIsValid'), 13],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getFlag'), 21],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getEnabled'), 29],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getActiveFlag'), 70],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getValidated'), 75],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getProcessed'), 85],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, '_getPrivateBoolean'), 91],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'GetCamelCase'), 96],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getTrue'), 111],
            [sprintf(BooleanGetMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'getFalse'), 116],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/check_parameterized_methods.neon',
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(BooleanGetMethodNameRule::class);
    }
}
