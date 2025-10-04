<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCaseMethodName;

use Orrison\MeliorStan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowConsecutiveUppercaseAndPrefixTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(CamelCaseMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'do_something_invalid'), 56],
            [sprintf(CamelCaseMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'DoSomethingInvalid'), 58],
            [sprintf(CamelCaseMethodNameRule::ERROR_MESSAGE_TEMPLATE, 'test_with_underscores_invalid'), 64],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_consecutive_uppercase_and_prefix.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
