<?php

namespace Orrison\MeliorStan\Support;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Match_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Continue_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Goto_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\TryCatch;
use PhpParser\Node\Stmt\While_;
use PhpParser\NodeFinder;

class CognitiveComplexityCalculator
{
    public const string BOOL_KIND_AND = 'AND';

    public const string BOOL_KIND_OR = 'OR';

    public function calculate(FunctionLike $node): int
    {
        $score = 0;

        foreach ($node->getStmts() ?? [] as $stmt) {
            $score += $this->scoreNode($stmt, 0, null);
        }

        $name = $this->getEnclosingName($node);

        if ($name !== null && $this->hasDirectRecursion($node, $name, $node instanceof ClassMethod)) {
            $score += 1;
        }

        return $score;
    }

    protected function getEnclosingName(FunctionLike $node): ?string
    {
        if ($node instanceof ClassMethod || $node instanceof Function_) {
            return $node->name->toString();
        }

        return null;
    }

    protected function scoreNode(Node $node, int $nesting, ?string $parentBoolKind): int
    {
        if ($node instanceof If_) {
            return $this->scoreIf($node, $nesting);
        }

        if ($node instanceof For_) {
            return $this->scoreFor($node, $nesting);
        }

        if ($node instanceof Foreach_) {
            return $this->scoreForeach($node, $nesting);
        }

        if ($node instanceof While_ || $node instanceof Do_) {
            return $this->scoreWhileOrDo($node->cond, $node->stmts, $nesting);
        }

        if ($node instanceof Switch_) {
            return $this->scoreSwitch($node, $nesting);
        }

        if ($node instanceof TryCatch) {
            return $this->scoreTryCatch($node, $nesting);
        }

        if ($node instanceof Match_) {
            return $this->scoreMatch($node, $nesting);
        }

        if ($node instanceof Ternary) {
            return $this->scoreTernary($node, $nesting);
        }

        if ($node instanceof Closure || $node instanceof ArrowFunction) {
            return $this->scoreClosure($node, $nesting);
        }

        if ($node instanceof Goto_) {
            return 1;
        }

        if ($node instanceof Break_ || $node instanceof Continue_) {
            return $this->isMultiLevelJump($node) ? 1 : 0;
        }

        $thisKind = $this->getBoolKind($node);
        $score = 0;

        if ($thisKind !== null && $thisKind !== $parentBoolKind) {
            $score += 1;
        }

        $childKind = $thisKind;

        foreach ($node->getSubNodeNames() as $subNodeName) {
            $subNode = $node->{$subNodeName};

            if ($subNode instanceof Node) {
                $score += $this->scoreNode($subNode, $nesting, $childKind);
            } elseif (is_array($subNode)) {
                foreach ($subNode as $item) {
                    if ($item instanceof Node) {
                        $score += $this->scoreNode($item, $nesting, $childKind);
                    }
                }
            }
        }

        return $score;
    }

    protected function getBoolKind(Node $node): ?string
    {
        if ($node instanceof BooleanAnd || $node instanceof LogicalAnd) {
            return self::BOOL_KIND_AND;
        }

        if ($node instanceof BooleanOr || $node instanceof LogicalOr) {
            return self::BOOL_KIND_OR;
        }

        return null;
    }

    protected function scoreIf(If_ $node, int $nesting): int
    {
        $score = 1 + $nesting;
        $score += $this->scoreNode($node->cond, $nesting, null);

        foreach ($node->stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting + 1, null);
        }

        foreach ($node->elseifs as $elseif) {
            $score += 1;
            $score += $this->scoreNode($elseif->cond, $nesting, null);

            foreach ($elseif->stmts as $stmt) {
                $score += $this->scoreNode($stmt, $nesting + 1, null);
            }
        }

        if ($node->else !== null) {
            $score += 1;

            foreach ($node->else->stmts as $stmt) {
                $score += $this->scoreNode($stmt, $nesting + 1, null);
            }
        }

        return $score;
    }

    protected function scoreFor(For_ $node, int $nesting): int
    {
        $score = 1 + $nesting;

        foreach ($node->init as $expr) {
            $score += $this->scoreNode($expr, $nesting, null);
        }

        foreach ($node->cond as $expr) {
            $score += $this->scoreNode($expr, $nesting, null);
        }

        foreach ($node->loop as $expr) {
            $score += $this->scoreNode($expr, $nesting, null);
        }

        foreach ($node->stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting + 1, null);
        }

        return $score;
    }

    protected function scoreForeach(Foreach_ $node, int $nesting): int
    {
        $score = 1 + $nesting;
        $score += $this->scoreNode($node->expr, $nesting, null);

        foreach ($node->stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting + 1, null);
        }

        return $score;
    }

    /**
     * @param Node\Stmt[] $stmts
     */
    protected function scoreWhileOrDo(Expr $cond, array $stmts, int $nesting): int
    {
        $score = 1 + $nesting;
        $score += $this->scoreNode($cond, $nesting, null);

        foreach ($stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting + 1, null);
        }

        return $score;
    }

    protected function scoreSwitch(Switch_ $node, int $nesting): int
    {
        $score = 1 + $nesting;
        $score += $this->scoreNode($node->cond, $nesting, null);

        foreach ($node->cases as $case) {
            if ($case->cond !== null) {
                $score += $this->scoreNode($case->cond, $nesting + 1, null);
            }

            foreach ($case->stmts as $stmt) {
                $score += $this->scoreNode($stmt, $nesting + 1, null);
            }
        }

        return $score;
    }

    protected function scoreTryCatch(TryCatch $node, int $nesting): int
    {
        $score = 0;

        foreach ($node->stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting, null);
        }

        foreach ($node->catches as $catch) {
            $score += $this->scoreCatch($catch, $nesting);
        }

        if ($node->finally !== null) {
            foreach ($node->finally->stmts as $stmt) {
                $score += $this->scoreNode($stmt, $nesting, null);
            }
        }

        return $score;
    }

    protected function scoreCatch(Catch_ $node, int $nesting): int
    {
        $score = 1 + $nesting;

        foreach ($node->stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting + 1, null);
        }

        return $score;
    }

    protected function scoreMatch(Match_ $node, int $nesting): int
    {
        $score = 1 + $nesting;
        $score += $this->scoreNode($node->cond, $nesting, null);

        foreach ($node->arms as $arm) {
            if ($arm->conds !== null) {
                foreach ($arm->conds as $cond) {
                    $score += $this->scoreNode($cond, $nesting + 1, null);
                }
            }

            $score += $this->scoreNode($arm->body, $nesting + 1, null);
        }

        return $score;
    }

    protected function scoreTernary(Ternary $node, int $nesting): int
    {
        $score = 1 + $nesting;
        $score += $this->scoreNode($node->cond, $nesting, null);

        if ($node->if !== null) {
            $score += $this->scoreNode($node->if, $nesting + 1, null);
        }

        $score += $this->scoreNode($node->else, $nesting + 1, null);

        return $score;
    }

    protected function scoreClosure(Closure|ArrowFunction $node, int $nesting): int
    {
        if ($node instanceof ArrowFunction) {
            return $this->scoreNode($node->expr, $nesting + 1, null);
        }

        $score = 0;

        foreach ($node->stmts as $stmt) {
            $score += $this->scoreNode($stmt, $nesting + 1, null);
        }

        return $score;
    }

    protected function isMultiLevelJump(Break_|Continue_ $node): bool
    {
        if ($node->num === null) {
            return false;
        }

        if ($node->num instanceof Int_) {
            return $node->num->value >= 2;
        }

        return true;
    }

    protected function hasDirectRecursion(FunctionLike $node, string $name, bool $isMethod): bool
    {
        $finder = new NodeFinder();

        $found = $finder->findFirst(
            $node->getStmts() ?? [],
            function (Node $n) use ($name, $isMethod): bool {
                if ($isMethod) {
                    if ($n instanceof MethodCall
                        && $n->var instanceof Variable
                        && $n->var->name === 'this'
                        && $n->name instanceof Identifier
                        && $n->name->toString() === $name
                    ) {
                        return true;
                    }

                    if ($n instanceof StaticCall
                        && $n->class instanceof Name
                        && in_array($n->class->toString(), ['self', 'static'], true)
                        && $n->name instanceof Identifier
                        && $n->name->toString() === $name
                    ) {
                        return true;
                    }

                    return false;
                }

                return $n instanceof FuncCall
                    && $n->name instanceof Name
                    && $n->name->toString() === $name;
            }
        );

        return $found !== null;
    }
}
