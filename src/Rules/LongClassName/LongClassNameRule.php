<?php

namespace Orrison\MessedUpPhpstan\Rules\LongClassName;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\Stmt\Enum_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_|Interface_|Trait_|Enum_>
 */
class LongClassNameRule implements Rule
{
    public function __construct(
        protected Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Node\Stmt\ClassLike::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        // Skip anonymous classes
        if ($node->name === null) {
            return [];
        }

        $name = $node->name->name;
        $effectiveLength = $this->calculateEffectiveLength($name);
        $maximum = $this->config->getMaximum();

        if ($effectiveLength > $maximum) {
            $nodeType = $this->getNodeTypeName($node);
            $messages[] = RuleErrorBuilder::message(
                sprintf('%s name "%s" exceeds maximum length of %d characters (effective length: %d).', 
                    $nodeType, $name, $maximum, $effectiveLength)
            )
                ->identifier('MessedUpPhpstan.longClassName')
                ->build();
        }

        return $messages;
    }

    private function calculateEffectiveLength(string $name): int
    {
        $length = strlen($name);

        // Subtract first matching prefix
        foreach ($this->config->getSubtractPrefixes() as $prefix) {
            if ($prefix !== '' && strpos($name, $prefix) === 0) {
                $length -= strlen($prefix);
                break;
            }
        }

        // Subtract first matching suffix
        foreach ($this->config->getSubtractSuffixes() as $suffix) {
            if ($suffix !== '' && substr($name, -strlen($suffix)) === $suffix) {
                $length -= strlen($suffix);
                break;
            }
        }

        return $length;
    }

    private function getNodeTypeName(Node $node): string
    {
        return match (true) {
            $node instanceof Class_ => 'Class',
            $node instanceof Interface_ => 'Interface',
            $node instanceof Trait_ => 'Trait',
            $node instanceof Enum_ => 'Enum',
            default => 'Class-like',
        };
    }
}