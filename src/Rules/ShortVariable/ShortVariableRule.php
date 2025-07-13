<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortVariable;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
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
    /** @var array<string, int> Track variables processed in special contexts by name and line */
    private array $specialContextVariables = [];

    public function __construct(
        protected Config $config,
    ) {
    }

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
        // Reset tracking at the start of each file/class
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
            $this->specialContextVariables = [];
        }

        // Process for loop variable declarations
        if ($node instanceof For_) {
            return $this->processForLoop($node);
        }

        // Process foreach variable declarations
        if ($node instanceof Foreach_) {
            return $this->processForeach($node);
        }

        // Process catch variable declarations
        if ($node instanceof Catch_) {
            return $this->processCatch($node);
        }

        // Process parameters
        if ($node instanceof Param) {
            return $this->processParameter($node);
        }

        // Process properties
        if ($node instanceof Property) {
            return $this->processProperty($node);
        }

        // Process assignment expressions that contain variables
        if ($node instanceof \PhpParser\Node\Expr\Assign) {
            return $this->processAssignment($node);
        }

        return [];
    }

    /**
     * Process assignment expressions to check for short variable names
     * @return RuleError[]
     */
    private function processAssignment(\PhpParser\Node\Expr\Assign $node): array
    {
        // Only check the left side (the variable being assigned to)
        $var = $node->var;
        if ($var instanceof Variable && is_string($var->name)) {
            // Check if this variable was already processed in a special context
            $line = $var->getLine();
            $key = $var->name . '_' . $line;

            if (isset($this->specialContextVariables[$key])) {
                // Already processed by special context processor
                return [];
            }

            return $this->checkVariableLength($var);
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    private function processForLoop(For_ $node): array
    {
        $errors = [];

        // Check variables defined in for loop init expressions
        foreach ($node->init as $expr) {
            if ($expr instanceof \PhpParser\Node\Expr\Assign) {
                $var = $expr->var;
                if ($var instanceof Variable && is_string($var->name)) {
                    // Track this variable as processed in special context
                    $line = $var->getLine();
                    $this->specialContextVariables[$var->name . '_' . $line] = $line;

                    // Only report if allow_in_for_loops is false
                    if (!$this->config->getAllowInForLoops()) {
                        $errors = array_merge($errors, $this->checkVariableLength($var));
                    }
                }
            }
        }

        // Check variables in for loop increment expressions
        foreach ($node->loop as $expr) {
            if ($expr instanceof \PhpParser\Node\Expr\PostInc || $expr instanceof \PhpParser\Node\Expr\PreInc ||
                $expr instanceof \PhpParser\Node\Expr\PostDec || $expr instanceof \PhpParser\Node\Expr\PreDec) {
                $var = $expr->var;
                if ($var instanceof Variable && is_string($var->name)) {
                    // Track this variable as processed in special context
                    $line = $var->getLine();
                    $this->specialContextVariables[$var->name . '_' . $line] = $line;

                    // Only report if allow_in_for_loops is false
                    if (!$this->config->getAllowInForLoops()) {
                        $errors = array_merge($errors, $this->checkVariableLength($var));
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * @return RuleError[]
     */
    private function processForeach(Foreach_ $node): array
    {
        $errors = [];

        // Check key variable if present
        if ($node->keyVar instanceof Variable && is_string($node->keyVar->name)) {
            // Track this variable as processed in special context
            $line = $node->keyVar->getLine();
            $this->specialContextVariables[$node->keyVar->name . '_' . $line] = $line;

            // Only report if allow_in_foreach is false
            if (!$this->config->getAllowInForeach()) {
                $errors = array_merge($errors, $this->checkVariableLength($node->keyVar));
            }
        }

        // Check value variable
        $valueVar = $node->valueVar;
        if ($valueVar instanceof Variable && is_string($valueVar->name)) {
            // Track this variable as processed in special context
            $line = $valueVar->getLine();
            $this->specialContextVariables[$valueVar->name . '_' . $line] = $line;

            // Only report if allow_in_foreach is false
            if (!$this->config->getAllowInForeach()) {
                $errors = array_merge($errors, $this->checkVariableLength($valueVar));
            }
        }

        return $errors;
    }

    /**
     * @return RuleError[]
     */
    private function processCatch(Catch_ $node): array
    {
        $errors = [];

        // Check catch variable
        $catchVar = $node->var;
        if ($catchVar instanceof Variable && is_string($catchVar->name)) {
            // Track this variable as processed in special context
            $line = $catchVar->getLine();
            $this->specialContextVariables[$catchVar->name . '_' . $line] = $line;

            // Only report if allow_in_catch is false
            if (!$this->config->getAllowInCatch()) {
                $errors = array_merge($errors, $this->checkVariableLength($catchVar));
            }
        }

        return $errors;
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

    /**
     * @return RuleError[]
     */
    private function checkVariableLength(Variable $node): array
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
}
