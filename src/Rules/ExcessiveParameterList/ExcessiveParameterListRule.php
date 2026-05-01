<?php

namespace Orrison\MeliorStan\Rules\ExcessiveParameterList;

use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FunctionLike>
 */
class ExcessiveParameterListRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s has %d parameters, which exceeds the maximum of %d. Consider grouping parameters into a value object.';

    public function __construct(
        protected Config $config,
    ) {}

    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /**
     * @param FunctionLike $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $name = $this->getName($node);

        if ($name !== null && $this->shouldIgnoreByPattern($name)) {
            return [];
        }

        $paramCount = count($node->getParams());

        if ($paramCount <= $this->config->getMaximum()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $this->describeNode($node, $name), $paramCount, $this->config->getMaximum())
            )
                ->identifier('MeliorStan.excessiveParameterList')
                ->build(),
        ];
    }

    protected function getName(FunctionLike $node): ?string
    {
        if ($node instanceof ClassMethod || $node instanceof Function_) {
            return $node->name->toString();
        }

        return null;
    }

    protected function shouldIgnoreByPattern(string $name): bool
    {
        $pattern = $this->config->getIgnorePattern();

        if ($pattern === '') {
            return false;
        }

        $regex = '~' . $pattern . '~i';

        $result = @preg_match($regex, $name);

        if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
            $error = preg_last_error_msg();

            throw new InvalidArgumentException(
                sprintf('Invalid regex pattern in ignore_pattern configuration: "%s". Error: %s', $pattern, $error)
            );
        }

        return $result === 1;
    }

    protected function describeNode(FunctionLike $node, ?string $name): string
    {
        if ($node instanceof ClassMethod) {
            return sprintf('Method "%s"', $name);
        }

        if ($node instanceof Function_) {
            return sprintf('Function "%s"', $name);
        }

        if ($node instanceof ArrowFunction) {
            return 'Arrow function';
        }

        return 'Closure';
    }
}
