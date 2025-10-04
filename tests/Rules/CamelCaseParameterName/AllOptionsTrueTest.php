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
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 5],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 6],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 8],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 9],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 18],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 19],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 21],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 22],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 33],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 34],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 36],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 37],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 46],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 47],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 49],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 50],

            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 59],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 60],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 62],
            [sprintf(CamelCaseParameterNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 63],
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
