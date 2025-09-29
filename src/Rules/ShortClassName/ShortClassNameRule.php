<?php

namespace Orrison\MeliorStan\Rules\ShortClassName;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class ShortClassNameRule implements Rule
{
    public function __construct(
        protected Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Node\Identifier) {
            return [];
        }

        $className = $node->name->toString();

        // Check if class name is in exceptions list
        if (in_array($className, $this->config->getExceptions(), true)) {
            return [];
        }

        // Check if class name is shorter than minimum length
        if (strlen($className) < $this->config->getMinimum()) {
            $nodeType = $this->getNodeTypeName($node);

            return [
                RuleErrorBuilder::message(
                    sprintf(
                        '%s name "%s" is too short (%d chars). Minimum allowed length is %d characters.',
                        $nodeType,
                        $className,
                        strlen($className),
                        $this->config->getMinimum()
                    )
                )
                    ->identifier('MeliorStan.shortClassName')
                    ->build(),
            ];
        }

        return [];
    }

    private function getNodeTypeName(ClassLike $node): string
    {
        if ($node instanceof Node\Stmt\Class_) {
            return 'Class';
        }

        if ($node instanceof Node\Stmt\Interface_) {
            return 'Interface';
        }

        if ($node instanceof Node\Stmt\Trait_) {
            return 'Trait';
        }

        if ($node instanceof Node\Stmt\Enum_) {
            return 'Enum';
        }

        return 'Class';
    }
}