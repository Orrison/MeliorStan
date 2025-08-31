<?php

namespace Orrison\MeliorStan\Rules\CamelCaseVariableName;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\List_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\NodeVisitorAbstract;

/**
 * Node visitor that marks Variable nodes as definitions if they are in definition contexts.
 */
final class VariableDefinitionVisitor extends NodeVisitorAbstract
{
    public const ATTRIBUTE_NAME = 'isVariableDefinition';

    public function enterNode(Node $node): ?Node
    {
        if (! $node instanceof Variable) {
            return null;
        }

        if ($this->isVariableDefinition($node)) {
            $node->setAttribute(self::ATTRIBUTE_NAME, true);
        }

        return null;
    }

    private function isVariableDefinition(Variable $node): bool
    {
        $parent = $node->getAttribute('parent');

        // Early return if parent attribute is not set (e.g., if NodeConnectingVisitor is misconfigured)
        if ($parent === null) {
            return false;
        }

        // Check for assignment: $var = ...
        if ($parent instanceof Assign && $parent->var === $node) {
            return true;
        }

        // Check for foreach: foreach ($array as $var) or foreach ($array as $key => $var)
        if ($parent instanceof Foreach_) {
            if ($parent->valueVar === $node || $parent->keyVar === $node) {
                return true;
            }
        }

        // Check for for loop: for ($i = 0; ...)
        if ($parent instanceof For_) {
            foreach ($parent->init as $initExpr) {
                if ($initExpr instanceof Assign && $initExpr->var === $node) {
                    return true;
                }
            }
        }

        // Check for list destructuring: list($var) = ...
        if ($parent instanceof List_) {
            foreach ($parent->items as $item) {
                if ($item && $item->value === $node) {
                    return true;
                }
            }
        }

        return false;
    }
}
