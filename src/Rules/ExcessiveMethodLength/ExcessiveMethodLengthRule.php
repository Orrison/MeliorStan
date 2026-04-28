<?php

namespace Orrison\MeliorStan\Rules\ExcessiveMethodLength;

use InvalidArgumentException;
use PhpParser\Node;
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
class ExcessiveMethodLengthRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE_METHOD = 'Method "%s" has %d lines, which exceeds the maximum of %d. Consider refactoring.';

    public const string ERROR_MESSAGE_TEMPLATE_FUNCTION = 'Function "%s" has %d lines, which exceeds the maximum of %d. Consider refactoring.';

    public const string ERROR_MESSAGE_TEMPLATE_CLOSURE = 'Closure has %d lines, which exceeds the maximum of %d. Consider refactoring.';

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
        if ($node->getStmts() === null) {
            return [];
        }

        $name = $this->getName($node);

        if ($name !== null && $this->shouldIgnoreByPattern($name)) {
            return [];
        }

        $lineCount = $this->countLines($node, $scope->getFile());

        if ($lineCount <= $this->config->getMaximum()) {
            return [];
        }

        return [
            RuleErrorBuilder::message($this->buildErrorMessage($node, $name, $lineCount))
                ->identifier('MeliorStan.excessiveMethodLength')
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

        $regex = '/' . $pattern . '/i';

        $result = @preg_match($regex, $name);

        if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
            $error = preg_last_error_msg();

            throw new InvalidArgumentException(
                sprintf('Invalid regex pattern in ignore_pattern configuration: "%s". Error: %s', $pattern, $error)
            );
        }

        return $result === 1;
    }

    protected function countLines(FunctionLike $node, string $filePath): int
    {
        $start = $node->getStartLine();
        $end = $node->getEndLine();
        $totalLines = $end - $start + 1;

        if (! $this->config->getIgnoreWhitespace()) {
            return $totalLines;
        }

        $contents = @file_get_contents($filePath);

        if ($contents === false) {
            return $totalLines;
        }

        $lines = explode("\n", $contents);

        $count = 0;

        for ($i = $start - 1; $i <= $end - 1; ++$i) {
            if (! isset($lines[$i])) {
                continue;
            }

            if ($this->isCountableLine($lines[$i])) {
                ++$count;
            }
        }

        return $count;
    }

    protected function isCountableLine(string $line): bool
    {
        $trimmed = trim($line);

        if ($trimmed === '') {
            return false;
        }

        if (str_starts_with($trimmed, '//') || str_starts_with($trimmed, '#')) {
            return false;
        }

        if (str_starts_with($trimmed, '/*') || str_starts_with($trimmed, '*/') || str_starts_with($trimmed, '*')) {
            return false;
        }

        return true;
    }

    protected function buildErrorMessage(FunctionLike $node, ?string $name, int $lineCount): string
    {
        $maximum = $this->config->getMaximum();

        if ($node instanceof ClassMethod) {
            return sprintf(self::ERROR_MESSAGE_TEMPLATE_METHOD, $name, $lineCount, $maximum);
        }

        if ($node instanceof Function_) {
            return sprintf(self::ERROR_MESSAGE_TEMPLATE_FUNCTION, $name, $lineCount, $maximum);
        }

        if ($node instanceof Closure) {
            return sprintf(self::ERROR_MESSAGE_TEMPLATE_CLOSURE, $lineCount, $maximum);
        }

        return sprintf(self::ERROR_MESSAGE_TEMPLATE_CLOSURE, $lineCount, $maximum);
    }
}
