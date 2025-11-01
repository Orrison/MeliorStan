<?php

namespace Orrison\MeliorStan\Rules\BooleanArgumentFlag;

use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\UnionType;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FunctionLike>
 */
class BooleanArgumentFlagRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE_METHOD = 'Method "%s::%s()" has boolean parameter "$%s" which may indicate the method has multiple responsibilities.';

    public const ERROR_MESSAGE_TEMPLATE_FUNCTION = 'Function "%s()" has boolean parameter "$%s" which may indicate the function has multiple responsibilities.';

    public const ERROR_MESSAGE_TEMPLATE_CLOSURE = 'Closure has boolean parameter "$%s" which may indicate the closure has multiple responsibilities.';

    public function __construct(
        protected Config $config,
    ) {}

    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        // Check if this is a class method and if the class should be ignored
        if ($node instanceof ClassMethod && $this->shouldIgnoreByClass($scope)) {
            return [];
        }

        // Get the function/method name for pattern matching
        $functionName = $this->getFunctionName($node);

        if ($functionName !== null && $this->shouldIgnoreByPattern($functionName)) {
            return [];
        }

        $errors = [];

        // Check each parameter for boolean types
        foreach ($node->getParams() as $param) {
            if ($this->isBooleanType($param->type)) {
                $paramName = $param->var instanceof Node\Expr\Variable && is_string($param->var->name)
                    ? $param->var->name
                    : 'unknown';

                $errors[] = RuleErrorBuilder::message($this->buildErrorMessage($node, $scope, $paramName))
                    ->identifier('MeliorStan.booleanArgumentFlag')
                    ->build();
            }
        }

        return $errors;
    }

    protected function shouldIgnoreByClass(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();

        if ($classReflection === null) {
            return false;
        }

        $className = $classReflection->getName();
        $ignoredClasses = $this->config->getIgnoredInClasses();

        return in_array($className, $ignoredClasses, true);
    }

    protected function shouldIgnoreByPattern(string $functionName): bool
    {
        $pattern = $this->config->getIgnorePattern();

        if ($pattern === '') {
            return false;
        }

        $result = @preg_match($pattern, $functionName);

        // Check for both false return value and error codes
        if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
            $error = preg_last_error_msg();

            throw new InvalidArgumentException(
                sprintf('Invalid regex pattern in ignore_pattern configuration: "%s". Error: %s', $pattern, $error)
            );
        }

        return $result === 1;
    }

    protected function getFunctionName(FunctionLike $node): ?string
    {
        if ($node instanceof ClassMethod || $node instanceof Function_) {
            return $node->name->toString();
        }

        // Closures don't have names
        return null;
    }

    protected function isBooleanType(?Node $type): bool
    {
        if ($type === null) {
            return false;
        }

        // Direct bool identifier
        if ($type instanceof Identifier) {
            return $type->toString() === 'bool';
        }

        // Nullable type: ?bool
        if ($type instanceof NullableType) {
            return $this->isBooleanType($type->type);
        }

        // Union types: bool|null, int|bool, etc.
        if ($type instanceof UnionType) {
            foreach ($type->types as $unionType) {
                if ($this->isBooleanType($unionType)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function buildErrorMessage(FunctionLike $node, Scope $scope, string $paramName): string
    {
        if ($node instanceof ClassMethod) {
            $classReflection = $scope->getClassReflection();
            $className = $classReflection !== null ? $classReflection->getName() : 'Unknown';
            $methodName = $node->name->toString();

            return sprintf(self::ERROR_MESSAGE_TEMPLATE_METHOD, $className, $methodName, $paramName);
        }

        if ($node instanceof Function_) {
            $functionName = $node->name->toString();

            return sprintf(self::ERROR_MESSAGE_TEMPLATE_FUNCTION, $functionName, $paramName);
        }

        // Closure
        return sprintf(self::ERROR_MESSAGE_TEMPLATE_CLOSURE, $paramName);
    }
}
