<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\PascalCaseClassName\PascalCaseClassNameRule;

/**
 * @extends RuleTestCase<PascalCaseClassNameRule>
 */
class PascalCaseClassNameRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/PascalCaseClassNameRuleFixture.php'], [
            [
                'Class name "pascalCaseClassNameRuleFixture" is not in PascalCase.',
                5,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    // #[Override]
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(PascalCaseClassNameRule::class);
    }
}