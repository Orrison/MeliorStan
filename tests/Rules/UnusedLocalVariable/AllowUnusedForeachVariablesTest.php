<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable;

use Orrison\MeliorStan\Rules\UnusedLocalVariable\UnusedLocalVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedLocalVariableRule>
 */
class AllowUnusedForeachVariablesTest extends RuleTestCase
{
    public function testForeachVariablesAllowed(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ForeachVariables.php'], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_foreach.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedLocalVariableRule::class);
    }
}
