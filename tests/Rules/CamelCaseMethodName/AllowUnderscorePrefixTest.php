<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowUnderscorePrefixTest extends RuleTestCase
{
    public function testAllowUnderscorePrefix(): void
    {
        $this->analyse([__DIR__ . '/Fixture/AllowUnderscorePrefix.php'], []);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_underscore_prefix.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
