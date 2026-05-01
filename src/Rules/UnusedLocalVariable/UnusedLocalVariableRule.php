<?php

namespace Orrison\MeliorStan\Rules\UnusedLocalVariable;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignOp;
use PhpParser\Node\Expr\AssignRef;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\List_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Global_;
use PhpParser\Node\Stmt\Static_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FunctionLike>
 */
class UnusedLocalVariableRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Avoid unused local variable "$%s".';

    /** @var array<string, int|string> Cached exceptions list as a set for O(1) lookups */
    protected array $exceptionsSet = [];

    protected bool $allowUnusedForeachVariables;

    public function __construct(
        protected Config $config,
    ) {
        $this->allowUnusedForeachVariables = $this->config->getAllowUnusedForeachVariables();
        $this->exceptionsSet = array_flip($this->config->getExceptions());
    }

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        // Arrow functions consist of a single expression and cannot introduce
        // unused locals on their own; assignments inside them do not propagate.
        if ($node instanceof ArrowFunction) {
            return [];
        }

        $stmts = $node->getStmts();

        if ($stmts === null) {
            return [];
        }

        // Collect parameter names so we never report on parameter reassignments.
        // Parameters are handled by a separate UnusedFormalParameter concern.
        $paramNames = [];

        foreach ($node->getParams() as $param) {
            if ($param->var instanceof Variable && is_string($param->var->name)) {
                $paramNames[$param->var->name] = true;
            }
        }

        /** @var array<string, array{node: Variable, isForeach: bool}> $assigned */
        $assigned = [];
        /** @var array<string, true> $reads */
        $reads = [];
        $hasVariableVariable = false;

        foreach ($stmts as $stmt) {
            $this->walk($stmt, $assigned, $reads, $hasVariableVariable);
        }

        // Variable variables make static analysis unsafe, so bail out for this scope.
        if ($hasVariableVariable) {
            return [];
        }

        $errors = [];

        foreach ($assigned as $name => $info) {
            if (isset($reads[$name])) {
                continue;
            }

            if (isset($paramNames[$name])) {
                continue;
            }

            if (isset($this->exceptionsSet[$name])) {
                continue;
            }

            if ($info['isForeach'] && $this->allowUnusedForeachVariables) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $name)
            )
                ->identifier('MeliorStan.unusedLocalVariable')
                ->line($info['node']->getLine())
                ->build();
        }

        return $errors;
    }

    /**
     * Recursively walk a node, recording variable assignments and reads.
     *
     * @param array<string, array{node: Variable, isForeach: bool}> $assigned
     * @param array<string, true>                                   $reads
     */
    protected function walk(Node $node, array &$assigned, array &$reads, bool &$hasVariableVariable): void
    {
        // Nested function/method declarations have their own independent scope.
        if ($node instanceof Function_ || $node instanceof ClassMethod) {
            return;
        }

        if ($node instanceof Closure) {
            // Variables imported via `use (...)` are reads in the outer scope.
            foreach ($node->uses as $use) {
                if (is_string($use->var->name)) {
                    $reads[$use->var->name] = true;
                }
            }

            // Closure body has its own scope, so do not descend.
            return;
        }

        if ($node instanceof ArrowFunction) {
            // Arrow functions auto-capture by value, so any variable referenced
            // inside is a read of an outer-scope variable. Walk the body but
            // discard any assignments since they are local to the arrow fn.
            $discard = [];
            $this->walk($node->expr, $discard, $reads, $hasVariableVariable);

            return;
        }

        if ($node instanceof Assign) {
            $this->walk($node->expr, $assigned, $reads, $hasVariableVariable);
            $this->walkAssignTarget($node->var, $assigned, $reads, $hasVariableVariable, false);

            return;
        }

        if ($node instanceof AssignRef) {
            $this->walk($node->expr, $assigned, $reads, $hasVariableVariable);
            $this->walkAssignTarget($node->var, $assigned, $reads, $hasVariableVariable, false);

            return;
        }

        if ($node instanceof AssignOp) {
            // e.g. $x += 1: the LHS is both a read and a write.
            $this->walk($node->expr, $assigned, $reads, $hasVariableVariable);
            $this->walk($node->var, $assigned, $reads, $hasVariableVariable);

            if ($node->var instanceof Variable && is_string($node->var->name)) {
                $assigned[$node->var->name] ??= ['node' => $node->var, 'isForeach' => false];
            }

            return;
        }

        if ($node instanceof Foreach_) {
            $this->walk($node->expr, $assigned, $reads, $hasVariableVariable);

            if ($node->keyVar !== null) {
                $this->walkAssignTarget($node->keyVar, $assigned, $reads, $hasVariableVariable, true);
            }

            $this->walkAssignTarget($node->valueVar, $assigned, $reads, $hasVariableVariable, true);

            foreach ($node->stmts as $stmt) {
                $this->walk($stmt, $assigned, $reads, $hasVariableVariable);
            }

            return;
        }

        if ($node instanceof Catch_) {
            // Catch variables are syntactically required and treated as used.
            if ($node->var instanceof Variable && is_string($node->var->name)) {
                $reads[$node->var->name] = true;
            }

            foreach ($node->stmts as $stmt) {
                $this->walk($stmt, $assigned, $reads, $hasVariableVariable);
            }

            return;
        }

        if ($node instanceof Global_) {
            // Globals cross scope boundaries, so treat as used.
            foreach ($node->vars as $var) {
                if ($var instanceof Variable && is_string($var->name)) {
                    $reads[$var->name] = true;
                }
            }

            return;
        }

        if ($node instanceof Static_) {
            // Static declarations persist across calls, so treat as used.
            foreach ($node->vars as $staticVar) {
                if (is_string($staticVar->var->name)) {
                    $reads[$staticVar->var->name] = true;
                }

                if ($staticVar->default !== null) {
                    $this->walk($staticVar->default, $assigned, $reads, $hasVariableVariable);
                }
            }

            return;
        }

        if ($node instanceof FuncCall && $this->isCompactCall($node)) {
            // Each string-literal argument to compact() is a read of the named local.
            foreach ($node->args as $arg) {
                if ($arg instanceof Arg && $arg->value instanceof String_) {
                    $reads[$arg->value->value] = true;

                    continue;
                }

                $this->walk($arg, $assigned, $reads, $hasVariableVariable);
            }

            return;
        }

        if ($node instanceof Variable) {
            if (! is_string($node->name)) {
                // Variable variable: $$x or ${expr}
                $hasVariableVariable = true;
                $this->walk($node->name, $assigned, $reads, $hasVariableVariable);

                return;
            }

            $reads[$node->name] = true;

            return;
        }

        // Generic descent into child nodes.
        foreach ($node->getSubNodeNames() as $subNodeName) {
            $sub = $node->{$subNodeName};

            if ($sub instanceof Node) {
                $this->walk($sub, $assigned, $reads, $hasVariableVariable);
            } elseif (is_array($sub)) {
                foreach ($sub as $item) {
                    if ($item instanceof Node) {
                        $this->walk($item, $assigned, $reads, $hasVariableVariable);
                    }
                }
            }
        }
    }

    /**
     * Process an assignment target (LHS), recording variable writes.
     *
     * @param array<string, array{node: Variable, isForeach: bool}> $assigned
     * @param array<string, true>                                   $reads
     */
    protected function walkAssignTarget(
        Node $target,
        array &$assigned,
        array &$reads,
        bool &$hasVariableVariable,
        bool $isForeach,
    ): void {
        if ($target instanceof Variable) {
            if (! is_string($target->name)) {
                $hasVariableVariable = true;

                return;
            }

            if (! isset($assigned[$target->name])) {
                $assigned[$target->name] = ['node' => $target, 'isForeach' => $isForeach];
            }

            return;
        }

        if ($target instanceof List_ || $target instanceof Array_) {
            foreach ($target->items as $item) {
                if ($item === null) {
                    continue;
                }

                if ($item->key !== null) {
                    $this->walk($item->key, $assigned, $reads, $hasVariableVariable);
                }

                $this->walkAssignTarget($item->value, $assigned, $reads, $hasVariableVariable, $isForeach);
            }

            return;
        }

        if ($target instanceof ArrayDimFetch ||
            $target instanceof PropertyFetch ||
            $target instanceof StaticPropertyFetch) {
            // Writing into a sub-element of an existing variable/property is also
            // a read of the base, so walk normally.
            $this->walk($target, $assigned, $reads, $hasVariableVariable);

            return;
        }

        $this->walk($target, $assigned, $reads, $hasVariableVariable);
    }

    protected function isCompactCall(FuncCall $node): bool
    {
        if (! $node->name instanceof Name) {
            return false;
        }

        return strtolower($node->name->getLast()) === 'compact';
    }
}
