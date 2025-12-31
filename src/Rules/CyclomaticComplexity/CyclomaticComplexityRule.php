<?php

namespace Orrison\MeliorStan\Rules\CyclomaticComplexity;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Case_;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\Stmt\While_;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class CyclomaticComplexityRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE_METHOD = 'The %s %s() has a Cyclomatic Complexity of %d. The allowed threshold is %d.';

    public const string ERROR_MESSAGE_TEMPLATE_CLASS = 'The %s "%s" has an average Cyclomatic Complexity of %.2f. The allowed threshold is %d.';

    public function __construct(
        protected Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @param ClassLike $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
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
            $complexity = $this->calculateComplexity($method);
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

    protected function calculateComplexity(ClassMethod $method): int
    {
        $complexity = 1; // Base complexity for method entry

        $nodeFinder = new NodeFinder();

        /** @var Node[] $nodes */
        $nodes = $nodeFinder->find($method->stmts ?? [], function (Node $node): bool {
            return $node instanceof If_
                || $node instanceof ElseIf_
                || $node instanceof While_
                || $node instanceof Do_
                || $node instanceof For_
                || $node instanceof Foreach_
                || $node instanceof Case_
                || $node instanceof Catch_
                || $node instanceof Ternary
                || $node instanceof Coalesce
                || $node instanceof BooleanAnd
                || $node instanceof BooleanOr
                || $node instanceof LogicalAnd
                || $node instanceof LogicalOr;
        });

        foreach ($nodes as $node) {
            // Skip default case in switch statements
            if ($node instanceof Case_ && $node->cond === null) {
                continue;
            }
            $complexity++;
        }

        return $complexity;
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
