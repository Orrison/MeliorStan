<?php

namespace Orrison\MeliorStan\Rules\NpathComplexity;

use InvalidArgumentException;
use Orrison\MeliorStan\Support\NpathComplexityCalculator;
use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
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
class NpathComplexityRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s %s() has an NPath complexity of %d. The configured maximum is %d.';

    public const string ERROR_MESSAGE_OVERFLOW = '%s %s() has an NPath complexity that exceeds the maximum representable value. The configured maximum is %d.';

    public function __construct(
        protected Config $config,
        protected NpathComplexityCalculator $calculator,
    ) {}

    /**
     * @return class-string<Node>
     */
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
        if ($node instanceof Closure || $node instanceof ArrowFunction) {
            return [];
        }

        if (! ($node instanceof ClassMethod || $node instanceof Function_)) {
            return [];
        }

        $name = $node->name->toString();

        if ($this->shouldIgnoreByPattern($name)) {
            return [];
        }

        $complexity = $this->calculator->calculate($node);

        if ($complexity <= $this->config->getMaximum()) {
            return [];
        }

        $type = $node instanceof ClassMethod ? 'Method' : 'Function';

        if ($complexity === PHP_INT_MAX) {
            return [
                RuleErrorBuilder::message(
                    sprintf(self::ERROR_MESSAGE_OVERFLOW, $type, $name, $this->config->getMaximum())
                )
                    ->identifier('MeliorStan.npathComplexity')
                    ->build(),
            ];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $type, $name, $complexity, $this->config->getMaximum())
            )
                ->identifier('MeliorStan.npathComplexity')
                ->build(),
        ];
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
}
