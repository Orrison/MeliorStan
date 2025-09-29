<?php

namespace Orrison\MeliorStan\Rules\ShortClassName;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
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
        if (! $node->name instanceof Identifier) {
            return [];
        }

        $className = $node->name->toString();

        if (strlen($className) >= $this->config->getMinimum()) {
            return [];
        }

        if (in_array($className, $this->config->getExceptions(), true)) {
            return [];
        }

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

    private function getNodeTypeName(ClassLike $node): string
    {
        if ($node instanceof Class_) {
            return 'Class';
        }

        if ($node instanceof Interface_) {
            return 'Interface';
        }

        if ($node instanceof Trait_) {
            return 'Trait';
        }

        if ($node instanceof Enum_) {
            return 'Enum';
        }

        return 'Class';
    }
}
