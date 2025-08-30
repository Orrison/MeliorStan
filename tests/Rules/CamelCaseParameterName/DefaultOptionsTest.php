<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCaseParameterName;

use Orrison\MeliorStan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseParameterNameRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Parameter name "is_http_response" is not in camelCase.', 5],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 6],
            ['Parameter name "isHTTPResponse" is not in camelCase.', 7],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 8],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 9],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 10],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 11],

            ['Parameter name "is_http_response" is not in camelCase.', 18],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 19],
            ['Parameter name "isHTTPResponse" is not in camelCase.', 20],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 21],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 22],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 23],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 24],

            ['Parameter name "is_http_response" is not in camelCase.', 33],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 34],
            ['Parameter name "isHTTPResponse" is not in camelCase.', 35],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 36],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 37],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 38],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 39],

            ['Parameter name "is_http_response" is not in camelCase.', 46],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 47],
            ['Parameter name "isHTTPResponse" is not in camelCase.', 48],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 49],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 50],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 51],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 52],

            ['Parameter name "is_http_response" is not in camelCase.', 59],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 60],
            ['Parameter name "isHTTPResponse" is not in camelCase.', 61],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 62],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 63],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 64],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 65],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseParameterNameRule::class);
    }
}
