<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class CamelCaseMethodNameRuleTest extends RuleTestCase
{
    public function testValidCamelCase(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ValidCamelCase.php'], []);
    }

    public function testInvalidCamelCase(): void
    {
        $this->analyse([__DIR__ . '/Fixture/InvalidCamelCase.php'], [
            ['Method name "do_something" is not in camelCase.', 6],
            ['Method name "DoSomething" is not in camelCase.', 7],
            ['Method name "getHTTPResponse" is not in camelCase.', 8],
            ['Method name "_privateMethod" is not in camelCase.', 9],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
