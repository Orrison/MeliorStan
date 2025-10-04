<?php

namespace Orrison\MeliorStan\Tests\Rules\ElseExpression;

use Orrison\MeliorStan\Rules\ElseExpression\ElseExpressionRule;
use PhpParser\Node\Stmt\If_;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ElseExpressionRule>
 */
class DefaultTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [ElseExpressionRule::ERROR_MESSAGE, 29],
            [ElseExpressionRule::ERROR_MESSAGE, 38],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    /**
     * @return Rule<If_>
     */
    protected function getRule(): Rule
    {
        return $this->getContainer()->getByType(ElseExpressionRule::class);
    }
}
