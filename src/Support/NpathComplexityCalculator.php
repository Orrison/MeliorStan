<?php

namespace Orrison\MeliorStan\Support;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Match_;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\TryCatch;
use PhpParser\Node\Stmt\While_;

class NpathComplexityCalculator
{
    public function calculate(FunctionLike $node): int
    {
        return $this->calculateStmtList($node->getStmts() ?? []);
    }

    /**
     * @param Node\Stmt[] $stmts
     */
    protected function calculateStmtList(array $stmts): int
    {
        $npath = 1;

        foreach ($stmts as $stmt) {
            $stmtNpath = $this->calculateStmt($stmt);

            if ($stmtNpath > 1 && $npath > intdiv(PHP_INT_MAX, $stmtNpath)) {
                return PHP_INT_MAX;
            }

            $npath *= $stmtNpath;
        }

        return max(1, $npath);
    }

    protected function calculateStmt(Node $stmt): int
    {
        if ($stmt instanceof If_) {
            return $this->calculateIf($stmt);
        }

        if ($stmt instanceof While_) {
            return $this->countConditionPaths($stmt->cond) + $this->calculateStmtList($stmt->stmts) + 1;
        }

        if ($stmt instanceof Do_) {
            return $this->countConditionPaths($stmt->cond) + $this->calculateStmtList($stmt->stmts) + 1;
        }

        if ($stmt instanceof For_) {
            $condPaths = 0;

            foreach ($stmt->cond as $cond) {
                $condPaths += $this->countConditionPaths($cond);
            }

            return $condPaths + $this->calculateStmtList($stmt->stmts) + 1;
        }

        if ($stmt instanceof Foreach_) {
            return $this->calculateStmtList($stmt->stmts) + 1;
        }

        if ($stmt instanceof Switch_) {
            return $this->calculateSwitch($stmt);
        }

        if ($stmt instanceof TryCatch) {
            return $this->calculateTryCatch($stmt);
        }

        if ($stmt instanceof Return_) {
            return $stmt->expr !== null ? $this->calculateExprPaths($stmt->expr) : 1;
        }

        if ($stmt instanceof Expression) {
            return $this->calculateExprPaths($stmt->expr);
        }

        return 1;
    }

    protected function calculateIf(If_ $if): int
    {
        $npath = $this->countConditionPaths($if->cond) + $this->calculateStmtList($if->stmts);

        foreach ($if->elseifs as $elseif) {
            $npath += $this->countConditionPaths($elseif->cond) + $this->calculateStmtList($elseif->stmts);
        }

        if ($if->else !== null) {
            $npath += $this->calculateStmtList($if->else->stmts);
        } else {
            $npath += 1;
        }

        return max(1, $npath);
    }

    protected function calculateSwitch(Switch_ $switch): int
    {
        $hasDefault = false;
        $npath = 0;

        foreach ($switch->cases as $case) {
            if ($case->cond === null) {
                $hasDefault = true;
            }

            $npath += max(1, $this->calculateStmtList($case->stmts));
        }

        if (! $hasDefault) {
            $npath += 1;
        }

        return max(1, $npath);
    }

    protected function calculateTryCatch(TryCatch $tryCatch): int
    {
        $npath = $this->calculateStmtList($tryCatch->stmts);

        foreach ($tryCatch->catches as $catch) {
            $npath += $this->calculateStmtList($catch->stmts);
        }

        if ($tryCatch->finally !== null) {
            $finallyNpath = $this->calculateStmtList($tryCatch->finally->stmts);

            if ($finallyNpath > 1 && $npath > intdiv(PHP_INT_MAX, $finallyNpath)) {
                return PHP_INT_MAX;
            }

            $npath *= $finallyNpath;
        }

        return max(1, $npath);
    }

    protected function countConditionPaths(Node\Expr $expr): int
    {
        if ($expr instanceof Closure || $expr instanceof ArrowFunction) {
            return 0;
        }

        $count = ($expr instanceof BooleanAnd || $expr instanceof BooleanOr
            || $expr instanceof LogicalAnd || $expr instanceof LogicalOr) ? 1 : 0;

        foreach ($expr->getSubNodeNames() as $subNodeName) {
            $subNode = $expr->{$subNodeName};

            if ($subNode instanceof Node\Expr) {
                $count += $this->countConditionPaths($subNode);
            } elseif (is_array($subNode)) {
                foreach ($subNode as $item) {
                    if ($item instanceof Node\Expr) {
                        $count += $this->countConditionPaths($item);
                    }
                }
            }
        }

        return $count;
    }

    protected function calculateExprPaths(Node\Expr $expr): int
    {
        if ($expr instanceof Closure || $expr instanceof ArrowFunction) {
            return 1;
        }

        if ($expr instanceof Ternary) {
            $thenPaths = $expr->if !== null ? $this->calculateExprPaths($expr->if) : 1;

            return $thenPaths + $this->calculateExprPaths($expr->else);
        }

        if ($expr instanceof Coalesce) {
            return $this->calculateExprPaths($expr->left) + $this->calculateExprPaths($expr->right);
        }

        if ($expr instanceof Match_) {
            return $this->calculateMatchPaths($expr);
        }

        $total = 1;

        foreach ($expr->getSubNodeNames() as $subNodeName) {
            $subNode = $expr->{$subNodeName};

            if ($subNode instanceof Node\Expr) {
                $subPaths = $this->calculateExprPaths($subNode);

                if ($subPaths > 1) {
                    $total += $subPaths - 1;
                }
            } elseif (is_array($subNode)) {
                foreach ($subNode as $item) {
                    if ($item instanceof Node\Expr) {
                        $subPaths = $this->calculateExprPaths($item);

                        if ($subPaths > 1) {
                            $total += $subPaths - 1;
                        }
                    } elseif ($item instanceof Node\Arg) {
                        $subPaths = $this->calculateExprPaths($item->value);

                        if ($subPaths > 1) {
                            $total += $subPaths - 1;
                        }
                    }
                }
            }
        }

        return $total;
    }

    protected function calculateMatchPaths(Match_ $match): int
    {
        $hasDefault = false;
        $total = 0;

        foreach ($match->arms as $arm) {
            if ($arm->conds === null) {
                $hasDefault = true;
            }

            $total += $this->calculateExprPaths($arm->body);
        }

        if (! $hasDefault) {
            $total += 1;
        }

        return max(1, $total);
    }
}
