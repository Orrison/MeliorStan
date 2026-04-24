<?php

namespace Orrison\MeliorStan\Rules\IfStatementAssignment;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\If_;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<If_>
 */
class IfStatementAssignmentRule implements Rule
{
    public const string ERROR_MESSAGE = 'Avoid assignments inside if and elseif conditions.';

    public function getNodeType(): string
    {
        return If_::class;
    }

    /**
     * @param If_ $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        foreach ($this->findAssignments($node->cond) as $assign) {
            $errors[] = RuleErrorBuilder::message(self::ERROR_MESSAGE)
                ->identifier('MeliorStan.ifStatementAssignment')
                ->line($assign->getStartLine())
                ->build();
        }

        foreach ($node->elseifs as $elseif) {
            foreach ($this->findAssignments($elseif->cond) as $assign) {
                $errors[] = RuleErrorBuilder::message(self::ERROR_MESSAGE)
                    ->identifier('MeliorStan.ifStatementAssignment')
                    ->line($assign->getStartLine())
                    ->build();
            }
        }

        return $errors;
    }

    /**
     * @return Assign[]
     */
    protected function findAssignments(Node $expr): array
    {
        return (new NodeFinder())->findInstanceOf($expr, Assign::class);
    }
}
