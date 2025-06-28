<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Orrison\MessedUpPhpstan\Rules\PascalCaseClassNameRule;

/**
 * @extends RuleTestCase<PascalCaseClassNameRule>
 */
class PascalCaseClassNameRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/PascalCaseClassNameRuleFixture.php'], [
            [
                'Class name "pascalCaseClassNameRuleFixture" is not in PascalCase.',
                5,
            ],
        ]);
    }

    protected function getRule(): Rule
    {
        return new PascalCaseClassNameRule();
    }
}