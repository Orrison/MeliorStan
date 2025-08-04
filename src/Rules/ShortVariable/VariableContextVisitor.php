<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortVariable;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeVisitorAbstract;

/**
 * Custom node visitor that preprocesses the AST to gather variable context information.
 * This visitor tracks variables defined in special contexts (for loops, foreach, catch blocks)
 * and marks them with attributes for the ShortVariableRule to use.
 */
final class VariableContextVisitor extends NodeVisitorAbstract
{
    public const ATTRIBUTE_SPECIAL_CONTEXT = 'shortVariableSpecialContext';

    public const ATTRIBUTE_EXEMPTION_TYPE = 'shortVariableExemptionType';

    public const EXEMPTION_FOR_LOOP = 'for_loop';

    public const EXEMPTION_FOREACH = 'foreach';

    public const EXEMPTION_CATCH = 'catch';

    public const EXEMPTION_PARAMETER = 'parameter';

    public function beforeTraverse(array $nodes): ?array
    {
        return null;
    }

    public function enterNode(Node $node): ?Node
    {
        if ($node instanceof For_) {
            $this->processForLoop($node);
        } elseif ($node instanceof Foreach_) {
            $this->processForeach($node);
        } elseif ($node instanceof Catch_) {
            $this->processCatch($node);
        } elseif ($node instanceof Function_) {
            $this->markFunctionParameters($node);
        } elseif ($node instanceof ClassMethod) {
            $this->markFunctionParameters($node);
        }

        return null;
    }

    private function processForLoop(For_ $node): void
    {
        // Track variables defined in for loop init expressions
        foreach ($node->init as $expr) {
            if ($expr instanceof Assign && $expr->var instanceof Variable && is_string($expr->var->name)) {
                $expr->var->setAttribute(self::ATTRIBUTE_SPECIAL_CONTEXT, true);
                $expr->var->setAttribute(self::ATTRIBUTE_EXEMPTION_TYPE, self::EXEMPTION_FOR_LOOP);
            }
        }

        // Track variables in for loop increment expressions
        foreach ($node->loop as $expr) {
            if (($expr instanceof PostInc || $expr instanceof PreInc ||
                 $expr instanceof PostDec || $expr instanceof PreDec) &&
                $expr->var instanceof Variable && is_string($expr->var->name)) {
                $expr->var->setAttribute(self::ATTRIBUTE_SPECIAL_CONTEXT, true);
                $expr->var->setAttribute(self::ATTRIBUTE_EXEMPTION_TYPE, self::EXEMPTION_FOR_LOOP);
            }
        }
    }

    private function processForeach(Foreach_ $node): void
    {
        // Track key variable if present
        if ($node->keyVar instanceof Variable && is_string($node->keyVar->name)) {
            $node->keyVar->setAttribute(self::ATTRIBUTE_SPECIAL_CONTEXT, true);
            $node->keyVar->setAttribute(self::ATTRIBUTE_EXEMPTION_TYPE, self::EXEMPTION_FOREACH);
        }

        // Track value variable
        if ($node->valueVar instanceof Variable && is_string($node->valueVar->name)) {
            $node->valueVar->setAttribute(self::ATTRIBUTE_SPECIAL_CONTEXT, true);
            $node->valueVar->setAttribute(self::ATTRIBUTE_EXEMPTION_TYPE, self::EXEMPTION_FOREACH);
        }
    }

    private function processCatch(Catch_ $node): void
    {
        // Track catch variable
        if ($node->var instanceof Variable && is_string($node->var->name)) {
            $node->var->setAttribute(self::ATTRIBUTE_SPECIAL_CONTEXT, true);
            $node->var->setAttribute(self::ATTRIBUTE_EXEMPTION_TYPE, self::EXEMPTION_CATCH);
        }
    }

    private function markFunctionParameters(Function_|ClassMethod $node): void
    {
        foreach ($node->params as $param) {
            if ($param->var instanceof Variable && is_string($param->var->name)) {
                $param->var->setAttribute(self::ATTRIBUTE_SPECIAL_CONTEXT, true);
                $param->var->setAttribute(self::ATTRIBUTE_EXEMPTION_TYPE, self::EXEMPTION_PARAMETER);
            }
        }
    }
}
