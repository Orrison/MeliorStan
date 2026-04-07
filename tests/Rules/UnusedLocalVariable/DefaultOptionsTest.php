<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable;

use Orrison\MeliorStan\Rules\UnusedLocalVariable\UnusedLocalVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedLocalVariableRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testBasicUnused(): void
    {
        $this->analyse([__DIR__ . '/Fixture/BasicUnused.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'unused'), 10],
        ]);
    }

    public function testCompactUsage(): void
    {
        $this->analyse([__DIR__ . '/Fixture/CompactUsage.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'stray'), 25],
        ]);
    }

    public function testStringInterpolation(): void
    {
        $this->analyse([__DIR__ . '/Fixture/StringInterpolation.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'dead'), 10],
        ]);
    }

    public function testForeachVariables(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ForeachVariables.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'key'), 14],
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'value'), 28],
        ]);
    }

    public function testCatchClause(): void
    {
        $this->analyse([__DIR__ . '/Fixture/CatchClause.php'], []);
    }

    public function testVariableVariableSuppressesAllReports(): void
    {
        $this->analyse([__DIR__ . '/Fixture/VariableVariable.php'], []);
    }

    public function testByReference(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ByReference.php'], []);
    }

    public function testClosureUse(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ClosureUse.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'stray'), 12],
        ]);
    }

    public function testListDestructuring(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ListDestructuring.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'second'), 17],
        ]);
    }

    public function testGlobalAndStatic(): void
    {
        $this->analyse([__DIR__ . '/Fixture/GlobalAndStatic.php'], []);
    }

    public function testExceptions(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExceptionsFixture.php'], [
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'unused'), 9],
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'tmp'), 10],
            [sprintf(UnusedLocalVariableRule::ERROR_MESSAGE_TEMPLATE, 'reported'), 11],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedLocalVariableRule::class);
    }
}
