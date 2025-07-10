<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseParameterName;

use Orrison\MessedUpPhpstan\Rules\CamelCaseParameterName\CamelCaseParameterNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCaseParameterNameRule>
 */
class AllOptionsTrueTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->markTestSkipped('must be revisited.');
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Parameter name "is_http_response" is not in camelCase.', 9],
            ['Parameter name "IsHttpResponse" is not in camelCase.', 11],
            ['Parameter name "IsHTTPResponse" is not in camelCase.', 15],
            ['Parameter name "ISHTTPRESPONSE" is not in camelCase.', 17],
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
