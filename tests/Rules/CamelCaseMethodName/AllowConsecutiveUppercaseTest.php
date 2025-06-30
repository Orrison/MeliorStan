<?php

declare(strict_types=1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\CamelCaseMethodNameRule;

/**
 * @extends RuleTestCase<CamelCaseMethodNameRule>
 */
class AllowConsecutiveUppercaseTest extends RuleTestCase
{
    public function testAllowConsecutiveUppercase(): void
    {
        $this->analyse([__DIR__ . '/Fixture/AllowConsecutiveUppercase.php'], []);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_consecutive_uppercase.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCaseMethodNameRule::class);
    }
}
