<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortVariable;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class ShortVariableRule implements Rule
{
    /** @var array<string, int|string> Cached exceptions list as a set for O(1) lookups */
    protected array $exceptionsSet = [];

    /** @var bool Cached config values */
    protected bool $allowInForLoops;

    protected bool $allowInForeach;

    protected bool $allowInCatch;

    protected int $minimumLength;

    public function __construct(
        protected Config $config,
    ) {
        // Cache config values for efficiency
        $this->allowInForLoops = $this->config->getAllowInForLoops();
        $this->allowInForeach = $this->config->getAllowInForeach();
        $this->allowInCatch = $this->config->getAllowInCatch();
        $this->minimumLength = $this->config->getMinimumLength();

        // Convert exceptions array to set for O(1) lookups
        $this->exceptionsSet = array_flip($this->config->getExceptions());
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
        // Process assignment expressions (regular variable assignments)
        if ($node instanceof Assign) {
            return $this->processAssignment($node);
        }

        // Process foreach key and value variables
        if ($node instanceof Foreach_) {
            return $this->processForeach($node);
        }

        // Process catch variables
        if ($node instanceof Catch_) {
            return $this->processCatch($node);
        }

        // Process for loop increment/decrement operations
        if ($node instanceof PostInc || $node instanceof PreInc ||
            $node instanceof PostDec || $node instanceof PreDec) {
            return $this->processIncrementDecrement($node);
        }

        return [];
    }

    /**
     * Process assignment expressions to check for short variable names
     *
     * @return RuleError[]
     */
    protected function processAssignment(Assign $node): array
    {
        // Only check the left side (the variable being assigned to)
        $var = $node->var;

        if (! $var instanceof Variable || ! is_string($var->name)) {
            return [];
        }

        return $this->checkVariableLength($var);
    }

    /**
     * @return RuleError[]
     */
    protected function processForeach(Foreach_ $node): array
    {
        $errors = [];

        // Check key variable if present
        if ($node->keyVar instanceof Variable && is_string($node->keyVar->name)) {
            $variableErrors = $this->checkVariableLength($node->keyVar);

            foreach ($variableErrors as $error) {
                $errors[] = $error;
            }
        }

        // Check value variable
        if ($node->valueVar instanceof Variable && is_string($node->valueVar->name)) {
            $variableErrors = $this->checkVariableLength($node->valueVar);

            foreach ($variableErrors as $error) {
                $errors[] = $error;
            }
        }

        return $errors;
    }

    /**
     * @return RuleError[]
     */
    protected function processCatch(Catch_ $node): array
    {
        // Check catch variable
        if ($node->var instanceof Variable && is_string($node->var->name)) {
            return $this->checkVariableLength($node->var);
        }

        return [];
    }

    /**
     * @param PostInc|PreInc|PostDec|PreDec $node
     *
     * @return RuleError[]
     */
    protected function processIncrementDecrement($node): array
    {
        if ($node->var instanceof Variable && is_string($node->var->name)) {
            return $this->checkVariableLength($node->var);
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    protected function checkVariableLength(Variable $node): array
    {
        // Skip variables with non-string names (dynamic variables like $$var)
        if (! is_string($node->name)) {
            return [];
        }

        $name = $node->name;

        // Check if variable is in exceptions list using O(1) lookup
        if (isset($this->exceptionsSet[$name])) {
            return [];
        }

        // Check if this variable is in a special context and if exemptions are enabled
        if ($node->hasAttribute(VariableContextVisitor::ATTRIBUTE_SPECIAL_CONTEXT)) {
            $exemptionType = $node->getAttribute(VariableContextVisitor::ATTRIBUTE_EXEMPTION_TYPE);

            if ($exemptionType === VariableContextVisitor::EXEMPTION_FOR_LOOP && $this->allowInForLoops) {
                return [];
            }

            if ($exemptionType === VariableContextVisitor::EXEMPTION_FOREACH && $this->allowInForeach) {
                return [];
            }

            if ($exemptionType === VariableContextVisitor::EXEMPTION_CATCH && $this->allowInCatch) {
                return [];
            }
        }

        if (strlen($name) < $this->minimumLength) {
            return [
                RuleErrorBuilder::message(
                    sprintf('Variable name "$%s" is shorter than minimum length of %d characters.', $name, $this->minimumLength)
                )->identifier('MessedUpPhpstan.shortVariable')
                    ->build(),
            ];
        }

        return [];
    }
}
