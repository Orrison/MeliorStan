<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCaseParameterName;

use Orrison\MeliorStan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule;
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

            ['Parameter name "is_http_response" is not in camelCase.', 17],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 18],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 20],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 21],

            ['Parameter name "is_http_response" is not in camelCase.', 31],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 32],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 34],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 35],

            ['Parameter name "is_http_response" is not in camelCase.', 43],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 44],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 46],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 47],

            ['Parameter name "is_http_response" is not in camelCase.', 55],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 56],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 58],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 59],
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
