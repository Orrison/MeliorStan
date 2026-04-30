<?php

namespace Orrison\MeliorStan\Rules\CyclomaticComplexity;

use Orrison\MeliorStan\Support\CyclomaticComplexityCalculator;
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
class CyclomaticComplexityRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE_METHOD = 'The %s %s() has a Cyclomatic Complexity of %d. The allowed threshold is %d.';

    public const string ERROR_MESSAGE_TEMPLATE_CLASS = 'The %s "%s" has an average Cyclomatic Complexity of %.2f. The allowed threshold is %d.';

    public function __construct(
        protected Config $config,
        protected CyclomaticComplexityCalculator $calculator,
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
            if (! $this->config->getShowMethodsComplexity() && ! $this->config->getShowClassesComplexity()) {
                return [];
            }

            return $this->processClassLike($node);
        }

        return [];
    }

    /**
     * @return RuleError[]
     */
    protected function processFunction(Function_ $node): array
    {
        if (! $this->config->getShowMethodsComplexity()) {
            return [];
        }

        $complexity = $this->calculator->calculate($node);

        if ($complexity <= $this->config->getReportLevel()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE_METHOD,
                    'function',
                    $node->name->toString(),
                    $complexity,
                    $this->config->getReportLevel()
                )
            )
                ->identifier('MeliorStan.cyclomaticComplexity.method')
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
            $complexity = $this->calculator->calculate($method);
            $totalComplexity += $complexity;

            if ($this->config->getShowMethodsComplexity() && $complexity > $this->config->getReportLevel()) {
                $errors[] = RuleErrorBuilder::message(
                    sprintf(
                        self::ERROR_MESSAGE_TEMPLATE_METHOD,
                        'method',
                        $method->name->toString(),
                        $complexity,
                        $this->config->getReportLevel()
                    )
                )
                    ->identifier('MeliorStan.cyclomaticComplexity.method')
                    ->line($method->getStartLine())
                    ->build();
            }
        }

        if ($this->config->getShowClassesComplexity()) {
            $averageComplexity = $totalComplexity / count($methods);

            if ($averageComplexity > $this->config->getReportLevel()) {
                $nodeType = $this->getNodeTypeName($node);
                $errors[] = RuleErrorBuilder::message(
                    sprintf(
                        self::ERROR_MESSAGE_TEMPLATE_CLASS,
                        $nodeType,
                        $node->name->toString(),
                        $averageComplexity,
                        $this->config->getReportLevel()
                    )
                )
                    ->identifier('MeliorStan.cyclomaticComplexity.class')
                    ->build();
            }
        }

        return $errors;
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
