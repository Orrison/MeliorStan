<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowUnderscorePrefixOnlyTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Method name "do_something_invalid" is not in camelCase.', 32],
            ['Method name "DoSomethingInvalid" is not in camelCase.', 33],
            ['Method name "getHTTPResponseInvalid" is not in camelCase.', 34],
            ['Method name "test_with_underscores_invalid" is not in camelCase.', 36],
            ['Method name "getXMLDataInvalid" is not in camelCase.', 37],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_underscore_prefix.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
