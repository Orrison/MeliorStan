<?php

namespace Orrison\MeliorStan\Rules\TooManyFields;

use PhpParser\Node;
use PhpParser\Node\Identifier;
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
class TooManyFieldsRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s "%s" has %d fields, which exceeds the maximum of %d. Consider refactoring.';

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

        if ($node instanceof Interface_ || $node instanceof Enum_) {
            return [];
        }

        $fieldCount = $this->countFields($node);

        if ($fieldCount <= $this->config->getMaxFields()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE,
                    $this->getNodeTypeName($node),
                    $node->name->toString(),
                    $fieldCount,
                    $this->config->getMaxFields()
                )
            )
                ->identifier('MeliorStan.tooManyFields')
                ->build(),
        ];
    }

    protected function countFields(ClassLike $node): int
    {
        $count = 0;

        foreach ($node->stmts as $stmt) {
            if (! $stmt instanceof Property) {
                continue;
            }

            if ($this->config->getIgnoreStaticProperties() && $stmt->isStatic()) {
                continue;
            }

            $count += count($stmt->props);
        }

        return $count;
    }

    protected function getNodeTypeName(ClassLike $node): string
    {
        if ($node instanceof Trait_) {
            return 'Trait';
        }

        return 'Class';
    }
}
