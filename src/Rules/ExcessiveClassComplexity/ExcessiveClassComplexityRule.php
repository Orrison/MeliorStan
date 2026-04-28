<?php

namespace Orrison\MeliorStan\Rules\ExcessiveClassComplexity;

use InvalidArgumentException;
use Orrison\MeliorStan\Support\CyclomaticComplexityCalculator;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class ExcessiveClassComplexityRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s has a Weighted Method Count of %d. The allowed maximum is %d. Consider distributing complexity among smaller classes.';

    public function __construct(
        protected Config $config,
        protected CyclomaticComplexityCalculator $calculator,
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
        $isAnonymous = $node instanceof Class_ && $node->isAnonymous();

        if (! $isAnonymous && ! $node->name instanceof Identifier) {
            return [];
        }

        $name = $node->name instanceof Identifier ? $node->name->toString() : '';

        if ($name !== '' && $this->shouldIgnoreByPattern($name)) {
            return [];
        }

        $totalComplexity = 0;

        foreach ($node->getMethods() as $method) {
            $totalComplexity += $this->calculator->calculate($method);
        }

        if ($totalComplexity <= $this->config->getMaximum()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $this->describeNode($node), $totalComplexity, $this->config->getMaximum())
            )
                ->identifier('MeliorStan.excessiveClassComplexity')
                ->build(),
        ];
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

    protected function describeNode(ClassLike $node): string
    {
        if ($node instanceof Class_ && $node->isAnonymous()) {
            return 'Anonymous class';
        }

        $name = $node->name instanceof Identifier ? $node->name->toString() : '';

        if ($node instanceof Interface_) {
            return sprintf('Interface "%s"', $name);
        }

        if ($node instanceof Trait_) {
            return sprintf('Trait "%s"', $name);
        }

        if ($node instanceof Enum_) {
            return sprintf('Enum "%s"', $name);
        }

        return sprintf('Class "%s"', $name);
    }
}
