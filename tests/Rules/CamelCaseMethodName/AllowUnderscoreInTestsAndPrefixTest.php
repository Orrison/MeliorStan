<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowUnderscoreInTestsAndPrefixTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php'
        ], [
            ['Method name "do_something_invalid" is not in camelCase.', 32],
            ['Method name "DoSomethingInvalid" is not in camelCase.', 33],
            ['Method name "getHTTPResponseInvalid" is not in camelCase.', 34],
            ['Method name "getXMLDataInvalid" is not in camelCase.', 37],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/combinations/allow_underscore_in_tests_and_prefix.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
