<?php

namespace Orrison\MessStan\Tests\Rules\CamelCaseParameterName;

use Orrison\MessStan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseParameterNameRule>
 */
class AllOptionsTrueTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Parameter name "is_http_response" is not in camelCase.', 5],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 6],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 8],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 9],

            ['Parameter name "is_http_response" is not in camelCase.', 16],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 17],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 19],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 20],

            ['Parameter name "is_http_response" is not in camelCase.', 29],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 30],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 32],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 33],

            ['Parameter name "is_http_response" is not in camelCase.', 40],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 41],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 43],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 44],

            ['Parameter name "is_http_response" is not in camelCase.', 51],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 52],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 54],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 55],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/all_options_true.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseParameterNameRule::class);
    }
}
