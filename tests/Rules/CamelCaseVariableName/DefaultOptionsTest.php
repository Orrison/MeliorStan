<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseVariableName;

use Orrison\MessedUpPhpstan\Rules\CamelCaseVariableName\CamelCaseVariableNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseVariableNameRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Variable name "$is_http_response" is not in camelCase.', 11],
            ['Variable name "$IsHttpResponse" is not in camelCase.', 13],
            ['Variable name "$isHTTPResponse" is not in camelCase.', 15],
            ['Variable name "$IsHTTPResponse" is not in camelCase.', 17],
            ['Variable name "$ISHTTPRESPONSE" is not in camelCase.', 19],
            ['Variable name "$_isHttpResponse" is not in camelCase.', 21],
            ['Variable name "$_isHTTPResponse" is not in camelCase.', 23],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseVariableNameRule::class);
    }
}
