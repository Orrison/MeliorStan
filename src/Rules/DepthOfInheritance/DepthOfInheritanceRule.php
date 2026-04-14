<?php

namespace Orrison\MeliorStan\Rules\DepthOfInheritance;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_>
 */
class DepthOfInheritanceRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Class "%s" has an inheritance depth of %d, which exceeds the maximum of %d.';

    public function __construct(
        protected Config $config,
        protected ReflectionProvider $reflectionProvider,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->isAnonymous()) {
            return [];
        }

        if (! $node->name instanceof Identifier) {
            return [];
        }

        $className = $node->namespacedName !== null
            ? $node->namespacedName->toString()
            : $node->name->toString();

        if ($this->isIgnoredClass($className)) {
            return [];
        }

        if (! $this->reflectionProvider->hasClass($className)) {
            return [];
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        $depth = $this->calculateDepth($classReflection);

        if ($depth <= $this->config->getMaximum()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE,
                    $node->name->toString(),
                    $depth,
                    $this->config->getMaximum()
                )
            )
                ->identifier('MeliorStan.depthOfInheritance')
                ->build(),
        ];
    }

    protected function calculateDepth(ClassReflection $classReflection): int
    {
        $depth = 0;
        $excludedNamespaces = $this->config->getExcludedNamespaces();
        $current = $classReflection->getParentClass();

        while ($current !== null) {
            if (! $this->isInExcludedNamespace($current->getName(), $excludedNamespaces)) {
                $depth++;
            }

            $current = $current->getParentClass();
        }

        return $depth;
    }

    protected function isIgnoredClass(string $className): bool
    {
        foreach ($this->config->getIgnoredClasses() as $ignoredClass) {
            if ($className === $ignoredClass) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string> $excludedNamespaces
     */
    protected function isInExcludedNamespace(string $className, array $excludedNamespaces): bool
    {
        foreach ($excludedNamespaces as $namespace) {
            if (str_starts_with($className, $namespace)) {
                return true;
            }
        }

        return false;
    }
}
