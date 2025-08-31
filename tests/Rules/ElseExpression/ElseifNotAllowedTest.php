<?php

namespace Orrison\MeliorStan\Tests\Rules\ElseExpression;

use Orrison\MeliorStan\Rules\ElseExpression\ElseExpressionRule;
use PhpParser\Node\Stmt\If_;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ElseExpressionRule>
 */
class ElseifNotAllowedTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            ['Avoid using else expressions.', 18],
            ['Avoid using else expressions.', 27],
            ['Avoid using else expressions.', 29],
            ['Avoid using else expressions.', 38],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/elseif_not_allowed.neon'];
    }

    /**
     * @return Rule<If_>
     */
    protected function getRule(): Rule
    {
        return $this->getContainer()->getByType(ElseExpressionRule::class);
    }
}
