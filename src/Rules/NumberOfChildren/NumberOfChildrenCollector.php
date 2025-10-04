<?php

namespace Orrison\MeliorStan\Rules\NumberOfChildren;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Collectors\Collector;

/**
 * @implements Collector<Class_, array<string, int>>
 */
class NumberOfChildrenCollector implements Collector
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): ?array
    {
        if ($node->name === null) {
            return null;
        }

        if ($node->extends === null) {
            return null;
        }

        // Get parent class name from the AST
        $namespacedName = $node->extends->getAttribute('namespacedName');

        if ($namespacedName instanceof Name) {
            $parentName = $namespacedName->toString();
        } else {
            // Fallback to resolving with current namespace
            $namespace = $scope->getNamespace();

            if ($namespace !== null && ! $node->extends instanceof Name\FullyQualified) {
                $parentName = $namespace . '\\' . $node->extends->toString();
            } else {
                $parentName = $node->extends->toString();
            }
        }

        return [$parentName => 1];
    }
}
