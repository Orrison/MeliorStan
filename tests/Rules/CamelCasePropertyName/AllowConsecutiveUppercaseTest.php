<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCasePropertyName;

use Orrison\MeliorStan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCasePropertyNameRule>
 */
class AllowConsecutiveUppercaseTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 9],
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 11],
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 15],
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 17],
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, '_isHttpResponse'), 19],
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 21],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_consecutive_uppercase.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCasePropertyNameRule::class);
    }
}
