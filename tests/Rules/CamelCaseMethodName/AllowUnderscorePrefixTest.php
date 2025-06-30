<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowUnderscorePrefixTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php'
        ], [
            ['Method name "do_something_invalid" is not in camelCase.', 13],
            ['Method name "DoSomethingInvalid" is not in camelCase.', 14],
            ['Method name "getHTTPResponseInvalid" is not in camelCase.', 15],
            ['Method name "test_with_underscores_invalid" is not in camelCase.', 17],
            ['Method name "getXMLDataInvalid" is not in camelCase.', 18],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_underscore_prefix.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
