<?php

namespace Orrison\MessStan\Tests\Rules\CamelCaseMethodName;

use Orrison\MessStan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;
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
            ['Method name "do_something_invalid" is not in camelCase.', 56],
            ['Method name "DoSomethingInvalid" is not in camelCase.', 58],
            ['Method name "test_with_underscores_invalid" is not in camelCase.', 64],
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
