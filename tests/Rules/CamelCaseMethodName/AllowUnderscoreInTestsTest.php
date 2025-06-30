<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowUnderscoreInTestsTest extends RuleTestCase
{
    public function testAllowUnderscoreInTests(): void
    {
        $this->analyse([__DIR__ . '/Fixture/AllowUnderscoreInTests.php'], []);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_underscore_in_tests.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
