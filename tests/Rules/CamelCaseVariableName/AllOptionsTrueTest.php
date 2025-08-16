<?php

namespace Orrison\MessStan\Tests\Rules\CamelCaseVariableName;

use Orrison\MessStan\Rules\CamelCaseVariableName\CamelCaseVariableNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseVariableNameRule>
 */
class AllOptionsTrueTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Variable name "$is_http_response" is not in camelCase.', 11],
            ['Variable name "$IsHttpResponse" is not in camelCase.', 13],
            ['Variable name "$IsHTTPResponse" is not in camelCase.', 17],
            ['Variable name "$ISHTTPRESPONSE" is not in camelCase.', 19],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/all_options_true.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseVariableNameRule::class);
    }
}
