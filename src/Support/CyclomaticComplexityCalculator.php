<?php

namespace Orrison\MeliorStan\Support;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Case_;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\While_;
use PhpParser\NodeFinder;

class CyclomaticComplexityCalculator
{
    public function calculate(FunctionLike $node): int
    {
        $complexity = 1; // Base complexity for method entry

        $nodeFinder = new NodeFinder();

        /** @var Node[] $nodes */
        $nodes = $nodeFinder->find($node->getStmts() ?? [], function (Node $node): bool {
            return $node instanceof If_
                || $node instanceof ElseIf_
                || $node instanceof While_
                || $node instanceof Do_
                || $node instanceof For_
                || $node instanceof Foreach_
                || $node instanceof Case_
                || $node instanceof Catch_
                || $node instanceof Ternary
                || $node instanceof Coalesce
                || $node instanceof BooleanAnd
                || $node instanceof BooleanOr
                || $node instanceof LogicalAnd
                || $node instanceof LogicalOr;
        });

        foreach ($nodes as $node) {
            // Skip default case in switch statements
            if ($node instanceof Case_ && $node->cond === null) {
                continue;
            }
            $complexity++;
        }

        return $complexity;
    }
}
