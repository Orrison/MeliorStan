<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCaseParameterName;

use Orrison\MeliorStan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseParameterNameRule>
 *
 */
class AllowConsecutiveUppercaseTest extends RuleTestCase
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
            ['Parameter name "_isHttpResponse" is not in camelCase.', 10],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 11],

            ['Parameter name "is_http_response" is not in camelCase.', 16],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 17],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 19],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 20],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 21],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 22],

            ['Parameter name "is_http_response" is not in camelCase.', 29],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 30],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 32],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 33],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 34],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 35],

            ['Parameter name "is_http_response" is not in camelCase.', 40],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 41],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 43],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 44],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 45],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 46],

            ['Parameter name "is_http_response" is not in camelCase.', 51],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 52],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 54],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 55],
            ['Parameter name "_isHttpResponse" is not in camelCase.', 56],
            ['Parameter name "_isHTTPResponse" is not in camelCase.', 57],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_consecutive_uppercase.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseParameterNameRule::class);
    }
}
