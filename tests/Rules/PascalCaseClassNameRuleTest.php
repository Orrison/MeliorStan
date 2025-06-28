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
                'Parameter #1 $a of anonymous function has no typehint.',
                37,
            ],
            [
                'Parameter #2 $b of anonymous function has no typehint.',
                37,
            ],
            [
                'Parameter #1 $c of anonymous function has no typehint.',
                46,
            ],
            [
                'Parameter #2 $d of anonymous function has no typehint.',
                46,
            ],
        ]);
    }

    protected function getRule(): Rule
    {
        return new PascalCaseClassNameRule();
    }
}