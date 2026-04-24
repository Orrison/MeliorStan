<?php

namespace Orrison\MeliorStan\Tests\Rules\IfStatementAssignment;

use Orrison\MeliorStan\Rules\IfStatementAssignment\IfStatementAssignmentRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<IfStatementAssignmentRule>
 */
class IfStatementAssignmentTest extends RuleTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/default.neon',
        ];
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/AssignmentInIfCondition.php',
                __DIR__ . '/Fixture/AssignmentInElseIfCondition.php',
                __DIR__ . '/Fixture/NestedAssignmentInCondition.php',
                __DIR__ . '/Fixture/ValidIfConditions.php',
            ],
            [
                [IfStatementAssignmentRule::ERROR_MESSAGE, 9],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 15],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 21],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 10],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 17],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 18],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 9],
                [IfStatementAssignmentRule::ERROR_MESSAGE, 15],
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new IfStatementAssignmentRule();
    }
}
