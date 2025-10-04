<?php

namespace Orrison\MeliorStan\Rules\NumberOfChildren;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Collectors\Collector;

/**
 * @implements Collector<Class_, array{parent: string|null, className: string, file: string, line: int}>
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

        // Get current class name
        $namespacedName = $node->namespacedName;
        $className = $namespacedName instanceof Name ? $namespacedName->toString() : '';

        if ($className === '') {
            return null;
        }

        // Get file and line info
        $file = $scope->getFile();
        $line = $node->getStartLine();

        // Get parent class name if exists
        $parentName = null;

        if ($node->extends !== null) {
            $parentNamespacedName = $node->extends->getAttribute('namespacedName');

            if ($parentNamespacedName instanceof Name) {
                $parentName = $parentNamespacedName->toString();
            } else {
                // Fallback to resolving with current namespace
                $namespace = $scope->getNamespace();

                if ($namespace !== null && ! $node->extends instanceof Name\FullyQualified) {
                    $parentName = $namespace . '\\' . $node->extends->toString();
                } else {
                    $parentName = $node->extends->toString();
                }
            }
        }

        return [
            'parent' => $parentName,
            'className' => $className,
            'file' => $file,
            'line' => $line,
        ];
    }
}
