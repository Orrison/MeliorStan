<?php

namespace Orrison\MeliorStan\Rules\CamelCaseVariableName;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayItem;
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
        if ($node instanceof Assign) {
            $this->markDefinitionTargets($node->var);
        }

        if ($node instanceof Foreach_) {
            $this->markDefinitionTargets($node->keyVar);
            $this->markDefinitionTargets($node->valueVar);
        }

        if ($node instanceof For_) {
            foreach ($node->init as $initExpr) {
                if ($initExpr instanceof Assign) {
                    $this->markDefinitionTargets($initExpr->var);
                }
            }
        }

        return null;
    }

    private function markDefinitionTargets(?Node $target): void
    {
        if ($target === null) {
            return;
        }

        if ($target instanceof Variable) {
            $target->setAttribute(self::ATTRIBUTE_NAME, true);

            return;
        }

        if ($target instanceof List_) {
            foreach ($target->items as $item) {
                if (! $item instanceof ArrayItem) {
                    continue;
                }

                $this->markDefinitionTargets($item->value);
            }
        }
    }
}
