<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortVariable;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
final class ShortVariableRule implements Rule
{
    public function __construct(
        protected Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Variable) {
            return $this->processVariable($node);
        }

        if ($node instanceof Param) {
            return $this->processParameter($node);
        }

        if ($node instanceof Property) {
            return $this->processProperty($node);
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    private function processVariable(Variable $node): array
    {
        // Skip variables with non-string names (dynamic variables like $$var)
        if (! is_string($node->name)) {
            return [];
        }

        $name = $node->name;

        // Check if variable is in exceptions list
        if (in_array($name, $this->config->getExceptions(), true)) {
            return [];
        }

        if (strlen($name) < $this->config->getMinimumLength()) {
            return [
                RuleErrorBuilder::message(
                    sprintf('Variable name "$%s" is shorter than minimum length of %d characters.', $name, $this->config->getMinimumLength())
                )->identifier('MessedUpPhpstan.shortVariable')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    private function processParameter(Param $node): array
    {
        if (! $node->var instanceof Variable || ! is_string($node->var->name)) {
            return [];
        }

        $name = $node->var->name;

        // Check if parameter is in exceptions list
        if (in_array($name, $this->config->getExceptions(), true)) {
            return [];
        }

        if (strlen($name) < $this->config->getMinimumLength()) {
            return [
                RuleErrorBuilder::message(
                    sprintf('Parameter name "$%s" is shorter than minimum length of %d characters.', $name, $this->config->getMinimumLength())
                )->identifier('MessedUpPhpstan.shortVariable')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    private function processProperty(Property $node): array
    {
        $errors = [];

        foreach ($node->props as $prop) {
            $name = $prop->name->name;

            // Check if property is in exceptions list
            if (in_array($name, $this->config->getExceptions(), true)) {
                continue;
            }

            if (strlen($name) < $this->config->getMinimumLength()) {
                $errors[] = RuleErrorBuilder::message(
                    sprintf('Property name "$%s" is shorter than minimum length of %d characters.', $name, $this->config->getMinimumLength())
                )->identifier('MessedUpPhpstan.shortVariable')
                    ->build();
            }
        }

        return $errors;
    }
}
