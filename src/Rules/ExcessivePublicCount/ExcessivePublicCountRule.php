<?php

namespace Orrison\MeliorStan\Rules\ExcessivePublicCount;

use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class ExcessivePublicCountRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s "%s" has %d public members (%d methods, %d properties), which exceeds the maximum of %d. Consider reducing the public API surface.';

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
     * @param ClassLike $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Identifier) {
            return [];
        }

        $publicMethods = $this->countPublicMethods($node);
        $publicProperties = $this->countPublicProperties($node);
        $total = $publicMethods + $publicProperties;

        if ($total <= $this->config->getMaximum()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE,
                    $this->getNodeTypeName($node),
                    $node->name->toString(),
                    $total,
                    $publicMethods,
                    $publicProperties,
                    $this->config->getMaximum()
                )
            )
                ->identifier('MeliorStan.excessivePublicCount')
                ->build(),
        ];
    }

    protected function countPublicMethods(ClassLike $node): int
    {
        $ignorePattern = $this->config->getIgnorePattern();
        $regex = $ignorePattern === '' ? null : '/' . $ignorePattern . '/i';
        $isInterface = $node instanceof Interface_;
        $count = 0;

        foreach ($node->getMethods() as $method) {
            if (! $isInterface && ! $method->isPublic()) {
                continue;
            }

            if ($regex !== null) {
                $methodName = $method->name->toString();
                $result = @preg_match($regex, $methodName);

                if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
                    throw new InvalidArgumentException(
                        sprintf(
                            'Invalid regex pattern in ignore_pattern configuration: "%s". Error: %s',
                            $ignorePattern,
                            preg_last_error_msg()
                        )
                    );
                }

                if ($result === 1) {
                    continue;
                }
            }

            ++$count;
        }

        return $count;
    }

    protected function countPublicProperties(ClassLike $node): int
    {
        if ($node instanceof Interface_ || $node instanceof Enum_) {
            return 0;
        }

        $count = 0;

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Property && $stmt->isPublic()) {
                $count += count($stmt->props);
            }
        }

        return $count;
    }

    protected function getNodeTypeName(ClassLike $node): string
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
