<?php

namespace Orrison\MeliorStan\Rules\LongClassName;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class LongClassNameRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE = '%s name "%s" is too long (%d chars). Maximum allowed length is %d characters.';

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
        $effectiveLength = $this->calculateEffectiveLength($className);

        if ($effectiveLength > $this->config->getMaximum()) {
            $nodeType = $this->getNodeTypeName($node);

            return [
                RuleErrorBuilder::message(
                    sprintf(
                        self::ERROR_MESSAGE_TEMPLATE,
                        $nodeType,
                        $className,
                        $effectiveLength,
                        $this->config->getMaximum()
                    )
                )
                    ->identifier('MeliorStan.longClassName')
                    ->build(),
            ];
        }

        return [];
    }

    private function calculateEffectiveLength(string $className): int
    {
        $effectiveClassName = $className;

        // Subtract suffixes first
        foreach ($this->config->getSubtractSuffixes() as $suffix) {
            if (str_ends_with($effectiveClassName, $suffix)) {
                $effectiveClassName = substr($effectiveClassName, 0, -strlen($suffix));

                break;
            }
        }

        // Then subtract prefixes
        foreach ($this->config->getSubtractPrefixes() as $prefix) {
            if (str_starts_with($effectiveClassName, $prefix)) {
                $effectiveClassName = substr($effectiveClassName, strlen($prefix));

                break;
            }
        }

        return strlen($effectiveClassName);
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
