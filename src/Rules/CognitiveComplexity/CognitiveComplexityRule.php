<?php

namespace Orrison\MeliorStan\Rules\CognitiveComplexity;

use InvalidArgumentException;
use Orrison\MeliorStan\Support\CognitiveComplexityCalculator;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Stmt>
 */
class CognitiveComplexityRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE_METHOD = 'The %s %s() has a Cognitive Complexity of %d. The allowed threshold is %d.';

    public const string ERROR_MESSAGE_TEMPLATE_CLASS = 'The %s "%s" has a total Cognitive Complexity of %d. The allowed threshold is %d.';

    public function __construct(
        protected Config $config,
        protected CognitiveComplexityCalculator $calculator,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Stmt::class;
    }

    /**
     * @param Stmt $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Function_) {
            return $this->processFunction($node);
        }

        if ($node instanceof ClassLike) {
            return $this->processClassLike($node);
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    protected function processFunction(Function_ $node): array
    {
        $name = $node->name->toString();

        if ($this->shouldIgnoreByPattern($name)) {
            return [];
        }

        $complexity = $this->calculator->calculate($node);

        if ($complexity <= $this->config->getMethodMaximum()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE_METHOD,
                    'function',
                    $name,
                    $complexity,
                    $this->config->getMethodMaximum()
                )
            )
                ->identifier('MeliorStan.cognitiveComplexity.method')
                ->build(),
        ];
    }

    /**
     * @return RuleError[]
     */
    protected function processClassLike(ClassLike $node): array
    {
        if (! $node->name instanceof Identifier) {
            return [];
        }

        $errors = [];
        $methods = $node->getMethods();

        if (count($methods) === 0) {
            return [];
        }

        $totalComplexity = 0;

        foreach ($methods as $method) {
            $methodName = $method->name->toString();

            if ($this->shouldIgnoreByPattern($methodName)) {
                continue;
            }

            $complexity = $this->calculator->calculate($method);
            $totalComplexity += $complexity;

            if ($complexity > $this->config->getMethodMaximum()) {
                $errors[] = RuleErrorBuilder::message(
                    sprintf(
                        self::ERROR_MESSAGE_TEMPLATE_METHOD,
                        'method',
                        $methodName,
                        $complexity,
                        $this->config->getMethodMaximum()
                    )
                )
                    ->identifier('MeliorStan.cognitiveComplexity.method')
                    ->line($method->getStartLine())
                    ->build();
            }
        }

        if ($totalComplexity > $this->config->getClassMaximum()) {
            $nodeType = $this->getNodeTypeName($node);
            $errors[] = RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE_CLASS,
                    $nodeType,
                    $node->name->toString(),
                    $totalComplexity,
                    $this->config->getClassMaximum()
                )
            )
                ->identifier('MeliorStan.cognitiveComplexity.class')
                ->build();
        }

        return $errors;
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

    protected function getNodeTypeName(ClassLike $node): string
    {
        if ($node instanceof Class_) {
            return 'class';
        }

        if ($node instanceof Interface_) {
            return 'interface';
        }

        if ($node instanceof Trait_) {
            return 'trait';
        }

        if ($node instanceof Enum_) {
            return 'enum';
        }

        return 'class';
    }
}
