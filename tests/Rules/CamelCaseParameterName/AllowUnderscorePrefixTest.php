<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCaseParameterName;

use Orrison\MeliorStan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseParameterNameRule>
 */
class AllowUnderscorePrefixTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 5],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 6],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'isHTTPResponse'), 7],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 8],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 9],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 11],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 18],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 19],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'isHTTPResponse'), 20],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 21],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 22],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 24],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 33],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 34],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'isHTTPResponse'), 35],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 36],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 37],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 39],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 46],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 47],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'isHTTPResponse'), 48],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 49],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 50],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 52],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 59],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 60],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'isHTTPResponse'), 61],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 62],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 63],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 65],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_underscore_prefix.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseParameterNameRule::class);
    }
}
