<?php

namespace Orrison\MeliorStan\Rules\NumberOfChildren;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Collectors\Collector;

/**
 * @implements Collector<Class_, array{string, string, int}>
 */
class ClassDeclarationCollector implements Collector
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

        // Get FQN from node attributes set by NameResolver
        $namespacedName = $node->namespacedName;

        if ($namespacedName instanceof Node\Name) {
            $className = $namespacedName->toString();
        } else {
            // Fallback: build FQN manually
            $namespace = $scope->getNamespace();
            $className = $namespace !== null
                ? $namespace . '\\' . $node->name->toString()
                : $node->name->toString();
        }

        $fileName = $scope->getFile();
        $line = $node->getStartLine();

        return [$className, $fileName, $line];
    }
}
