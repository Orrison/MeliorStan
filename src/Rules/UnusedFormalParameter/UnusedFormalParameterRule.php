<?php

namespace Orrison\MeliorStan\Rules\UnusedFormalParameter;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FunctionLike>
 */
class UnusedFormalParameterRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Avoid unused parameter "$%s".';

    /** @var array<string, true> */
    protected static array $magicMethods = [
        '__construct' => true,
        '__destruct' => true,
        '__call' => true,
        '__callstatic' => true,
        '__get' => true,
        '__set' => true,
        '__isset' => true,
        '__unset' => true,
        '__sleep' => true,
        '__wakeup' => true,
        '__serialize' => true,
        '__unserialize' => true,
        '__tostring' => true,
        '__invoke' => true,
        '__set_state' => true,
        '__clone' => true,
        '__debuginfo' => true,
    ];

    /** @var array<string, int|string> Cached exceptions list as a set for O(1) lookups */
    protected array $exceptionsSet = [];

    protected bool $allowUnusedWithInheritdoc;

    protected bool $allowOverridingMethods;

    public function __construct(
        protected Config $config,
    ) {
        $this->allowUnusedWithInheritdoc = $this->config->getAllowUnusedWithInheritdoc();
        $this->allowOverridingMethods = $this->config->getAllowOverridingMethods();
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
        // No body — abstract methods or interface methods.
        $stmts = $node->getStmts();

        if ($stmts === null && ! $node instanceof ArrowFunction) {
            return [];
        }

        // Per-method skip conditions.
        if ($node instanceof ClassMethod) {
            $methodName = strtolower($node->name->name);

            if (isset(self::$magicMethods[$methodName])) {
                return [];
            }

            if ($this->allowUnusedWithInheritdoc && $this->hasInheritDoc($node)) {
                return [];
            }

            if ($this->allowOverridingMethods && $this->isOverridingMethod($node, $scope)) {
                return [];
            }
        }

        // Collect param info first so we know which names to look for and which
        // ones to skip outright (promoted, exceptions).
        /** @var array<string, array{name: string, line: int}> $candidates */
        $candidates = [];

        foreach ($node->getParams() as $param) {
            if (! $param->var instanceof Variable || ! is_string($param->var->name)) {
                continue;
            }

            // Promoted constructor properties become real properties — never report.
            if ($param->flags !== 0) {
                continue;
            }

            $name = $param->var->name;

            if (isset($this->exceptionsSet[$name])) {
                continue;
            }

            $candidates[$name] = ['name' => $name, 'line' => $param->getLine()];
        }

        if ($candidates === []) {
            return [];
        }

        /** @var array<string, true> $reads */
        $reads = [];
        $hasVariableVariable = false;
        $usesFuncGetArgs = false;

        if ($node instanceof ArrowFunction) {
            // Arrow function body is its single expression.
            $this->walk($node->expr, $reads, $hasVariableVariable, $usesFuncGetArgs);
        } elseif ($stmts !== null) {
            foreach ($stmts as $stmt) {
                $this->walk($stmt, $reads, $hasVariableVariable, $usesFuncGetArgs);
            }
        }

        if ($hasVariableVariable || $usesFuncGetArgs) {
            return [];
        }

        $errors = [];

        foreach ($candidates as $name => $info) {
            if (isset($reads[$name])) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $name)
            )
                ->identifier('MeliorStan.unusedFormalParameter')
                ->line($info['line'])
                ->build();
        }

        return $errors;
    }

    /**
     * Recursively walk a node, recording variable reads and detecting bail-out conditions.
     *
     * @param array<string, true> $reads
     */
    protected function walk(Node $node, array &$reads, bool &$hasVariableVariable, bool &$usesFuncGetArgs): void
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

            // Closure body has its own scope — do not descend.
            return;
        }

        if ($node instanceof ArrowFunction) {
            // Arrow functions auto-capture by value — any variable referenced
            // inside is a read of an outer-scope variable.
            $this->walk($node->expr, $reads, $hasVariableVariable, $usesFuncGetArgs);

            return;
        }

        if ($node instanceof FuncCall) {
            if ($this->isFuncGetArgsCall($node)) {
                $usesFuncGetArgs = true;
            }

            if ($this->isCompactCall($node)) {
                foreach ($node->args as $arg) {
                    if ($arg instanceof Arg && $arg->value instanceof String_) {
                        $reads[$arg->value->value] = true;

                        continue;
                    }

                    $this->walk($arg, $reads, $hasVariableVariable, $usesFuncGetArgs);
                }

                return;
            }
        }

        if ($node instanceof Variable) {
            if (! is_string($node->name)) {
                $hasVariableVariable = true;
                $this->walk($node->name, $reads, $hasVariableVariable, $usesFuncGetArgs);

                return;
            }

            $reads[$node->name] = true;

            return;
        }

        // Generic descent into child nodes.
        foreach ($node->getSubNodeNames() as $subNodeName) {
            $sub = $node->{$subNodeName};

            if ($sub instanceof Node) {
                $this->walk($sub, $reads, $hasVariableVariable, $usesFuncGetArgs);
            } elseif (is_array($sub)) {
                foreach ($sub as $item) {
                    if ($item instanceof Node) {
                        $this->walk($item, $reads, $hasVariableVariable, $usesFuncGetArgs);
                    }
                }
            }
        }
    }

    protected function isCompactCall(FuncCall $node): bool
    {
        if (! $node->name instanceof Name) {
            return false;
        }

        return strtolower($node->name->getLast()) === 'compact';
    }

    protected function isFuncGetArgsCall(FuncCall $node): bool
    {
        if (! $node->name instanceof Name) {
            return false;
        }

        $name = strtolower($node->name->getLast());

        return $name === 'func_get_args' || $name === 'func_get_arg' || $name === 'func_num_args';
    }

    protected function hasInheritDoc(ClassMethod $node): bool
    {
        $doc = $node->getDocComment();

        if ($doc === null) {
            return false;
        }

        return stripos($doc->getText(), '@inheritdoc') !== false;
    }

    protected function isOverridingMethod(ClassMethod $node, Scope $scope): bool
    {
        $classRef = $scope->getClassReflection();

        if ($classRef === null) {
            return false;
        }

        $methodName = $node->name->name;

        foreach ($classRef->getParents() as $parent) {
            if ($parent->hasMethod($methodName)) {
                return true;
            }
        }

        foreach ($classRef->getInterfaces() as $interface) {
            if ($interface->hasMethod($methodName)) {
                return true;
            }
        }

        return false;
    }
}
