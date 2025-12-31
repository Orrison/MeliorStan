<?php

namespace Orrison\MeliorStan\Rules\TooManyMethods;

use InvalidArgumentException;
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
class TooManyMethodsRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s "%s" has %d methods, which exceeds the maximum of %d. Consider refactoring.';

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

        $methodCount = $this->countMethods($node);

        if ($methodCount <= $this->config->getMaxMethods()) {
            return [];
        }

        $nodeType = $this->getNodeTypeName($node);
        $nodeName = $node->name->toString();

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE,
                    $nodeType,
                    $nodeName,
                    $methodCount,
                    $this->config->getMaxMethods()
                )
            )
                ->identifier('MeliorStan.tooManyMethods')
                ->build(),
        ];
    }

    protected function countMethods(ClassLike $node): int
    {
        $ignorePattern = $this->config->getIgnorePattern();

        if ($ignorePattern === '') {
            return count($node->getMethods());
        }

        $regex = '/' . $ignorePattern . '/i';
        $count = 0;

        foreach ($node->getMethods() as $method) {
            $methodName = $method->name->toString();

            $result = @preg_match($regex, $methodName);

            // Check for both false return value and error codes
            if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
                $error = preg_last_error_msg();

                throw new InvalidArgumentException(
                    sprintf('Invalid regex pattern in ignore_pattern configuration: "%s". Error: %s', $ignorePattern, $error)
                );
            }

            if ($result === 0) {
                ++$count;
            }
        }

        return $count;
    }

    protected function getNodeTypeName(ClassLike $node): string
    {
        if ($node instanceof Class_) {
            return 'Class';
        }

        if ($node instanceof Interface_) {
            return 'Interface';
        }

        if ($node instanceof Trait_) {
            return 'Trait';
        }

        if ($node instanceof Enum_) {
            return 'Enum';
        }

        return 'Class';
    }
}
