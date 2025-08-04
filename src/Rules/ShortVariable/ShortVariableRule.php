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
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class ShortVariableRule implements Rule
{
    /** @var array<string, int> Track variables processed in special contexts by name and line */
    protected array $specialContextVariables = [];

    /** @var string|null Track current file being processed */
    protected ?string $currentFile = null;

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
        // Reset tracking when we detect a new file
        $currentFileName = $scope->getFile();

        if ($this->currentFile !== $currentFileName) {
            $this->currentFile = $currentFileName;
            $this->specialContextVariables = [];
        }

        // Reset tracking at the start of each file/class/namespace/function
        if ($node instanceof Class_ ||
            $node instanceof Namespace_ ||
            $node instanceof Function_ ||
            $node instanceof Interface_ ||
            $node instanceof Trait_) {
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

        // Process assignment expressions that contain variables
        if ($node instanceof Assign) {
            return $this->processAssignment($node);
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

        if ($var instanceof Variable && is_string($var->name)) {
            // Check if this variable was already processed in a special context
            $trackingKey = $var->name . '_' . $var->getLine();

            if (isset($this->specialContextVariables[$trackingKey])) {
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
    protected function processForLoop(For_ $node): array
    {
        $errors = [];

        // Check variables defined in for loop init expressions
        foreach ($node->init as $expr) {
            if ($expr instanceof Assign) {
                $var = $expr->var;

                if ($var instanceof Variable && is_string($var->name)) {
                    // Track this variable as processed in special context
                    $trackingKey = $var->name . '_' . $var->getLine();
                    $this->specialContextVariables[$trackingKey] = $var->getLine();

                    // Only report errors if exemption is not enabled
                    if (! $this->allowInForLoops) {
                        $variableErrors = $this->checkVariableLength($var);

                        foreach ($variableErrors as $error) {
                            $errors[] = $error;
                        }
                    }
                }
            }
        }

        // Check variables in for loop increment expressions
        foreach ($node->loop as $expr) {
            if ($expr instanceof PostInc || $expr instanceof PreInc ||
                $expr instanceof PostDec || $expr instanceof PreDec) {
                $var = $expr->var;

                if ($var instanceof Variable && is_string($var->name)) {
                    // Track this variable as processed in special context
                    $trackingKey = $var->name . '_' . $var->getLine();
                    $this->specialContextVariables[$trackingKey] = $var->getLine();

                    // Only report errors if exemption is not enabled
                    if (! $this->allowInForLoops) {
                        $variableErrors = $this->checkVariableLength($var);

                        foreach ($variableErrors as $error) {
                            $errors[] = $error;
                        }
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * @return RuleError[]
     */
    protected function processForeach(Foreach_ $node): array
    {
        $errors = [];

        // Check key variable if present
        if ($node->keyVar instanceof Variable && is_string($node->keyVar->name)) {
            // Track this variable as processed in special context
            $trackingKey = $node->keyVar->name . '_' . $node->keyVar->getLine();
            $this->specialContextVariables[$trackingKey] = $node->keyVar->getLine();

            // Only report errors if exemption is not enabled
            if (! $this->allowInForeach) {
                $variableErrors = $this->checkVariableLength($node->keyVar);

                foreach ($variableErrors as $error) {
                    $errors[] = $error;
                }
            }
        }

        // Check value variable
        $valueVar = $node->valueVar;

        if ($valueVar instanceof Variable && is_string($valueVar->name)) {
            // Track this variable as processed in special context
            $trackingKey = $valueVar->name . '_' . $valueVar->getLine();
            $this->specialContextVariables[$trackingKey] = $valueVar->getLine();

            // Only report errors if exemption is not enabled
            if (! $this->allowInForeach) {
                $variableErrors = $this->checkVariableLength($valueVar);

                foreach ($variableErrors as $error) {
                    $errors[] = $error;
                }
            }
        }

        return $errors;
    }

    /**
     * @return RuleError[]
     */
    protected function processCatch(Catch_ $node): array
    {
        $errors = [];

        // Check catch variable
        $catchVar = $node->var;

        if ($catchVar instanceof Variable && is_string($catchVar->name)) {
            // Track this variable as processed in special context
            $trackingKey = $catchVar->name . '_' . $catchVar->getLine();
            $this->specialContextVariables[$trackingKey] = $catchVar->getLine();

            // Only report errors if exemption is not enabled
            if (! $this->allowInCatch) {
                $variableErrors = $this->checkVariableLength($catchVar);

                foreach ($variableErrors as $error) {
                    $errors[] = $error;
                }
            }
        }

        return $errors;
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
