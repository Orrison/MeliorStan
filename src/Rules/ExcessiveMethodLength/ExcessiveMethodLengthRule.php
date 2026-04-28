<?php

namespace Orrison\MeliorStan\Rules\ExcessiveMethodLength;

use InvalidArgumentException;
use PhpParser\Node;
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
    public const string ERROR_MESSAGE_TEMPLATE = '%s has %d lines, which exceeds the maximum of %d. Consider refactoring.';

    /**
     * @var array<string, list<string>>
     */
    protected array $linesByFile = [];

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
            RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $this->describeNode($node, $name), $lineCount, $this->config->getMaximum())
            )
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

        $lines = $this->getFileLines($filePath);

        if ($lines === null) {
            return $totalLines;
        }

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

    /**
     * @return list<string>|null
     */
    protected function getFileLines(string $filePath): ?array
    {
        if (array_key_exists($filePath, $this->linesByFile)) {
            return $this->linesByFile[$filePath];
        }

        $contents = @file_get_contents($filePath);

        if ($contents === false) {
            return null;
        }

        return $this->linesByFile[$filePath] = explode("\n", $contents);
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

    protected function describeNode(FunctionLike $node, ?string $name): string
    {
        if ($node instanceof ClassMethod) {
            return sprintf('Method "%s"', $name);
        }

        if ($node instanceof Function_) {
            return sprintf('Function "%s"', $name);
        }

        return 'Closure';
    }
}
