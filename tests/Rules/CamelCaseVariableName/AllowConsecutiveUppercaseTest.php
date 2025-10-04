<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCaseVariableName;

use Orrison\MeliorStan\Rules\CamelCaseVariableName\CamelCaseVariableNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseVariableNameRule>
 */
class AllowConsecutiveUppercaseTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(CamelCaseVariableNameRule::ERROR_MESSAGE_TEMPLATE, 'is_http_response'), 11],
            [sprintf(CamelCaseVariableNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHttpResponse'), 13],
            [sprintf(CamelCaseVariableNameRule::ERROR_MESSAGE_TEMPLATE, 'IsHTTPResponse'), 17],
            [sprintf(CamelCaseVariableNameRule::ERROR_MESSAGE_TEMPLATE, 'ISHTTPRESPONSE'), 19],
            [sprintf(CamelCaseVariableNameRule::ERROR_MESSAGE_TEMPLATE, '_isHttpResponse'), 21],
            [sprintf(CamelCaseVariableNameRule::ERROR_MESSAGE_TEMPLATE, '_isHTTPResponse'), 23],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_consecutive_uppercase.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseVariableNameRule::class);
    }
}
