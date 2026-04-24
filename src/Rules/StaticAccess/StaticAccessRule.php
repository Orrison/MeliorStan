<?php

namespace Orrison\MeliorStan\Rules\StaticAccess;

use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class StaticAccessRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Avoid using static access to "%s::%s()". Use dependency injection instead.';

    public const string ERROR_MESSAGE_TEMPLATE_PROPERTY = 'Avoid using static access to "%s::$%s". Use dependency injection instead.';

    /** @var array<string, true> */
    protected const array SELF_REFERENCES = [
        'self' => true,
        'static' => true,
        'parent' => true,
    ];

    public function __construct(
        protected Config $config,
    ) {}

    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @return list<RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof StaticCall) {
            return $this->processStaticCall($node);
        }

        if ($node instanceof StaticPropertyFetch && $this->config->getCheckStaticPropertyAccess()) {
            return $this->processStaticPropertyFetch($node);
        }

        return [];
    }

    /**
     * @return list<RuleError>
     */
    protected function processStaticCall(StaticCall $node): array
    {
        if (! $node->class instanceof Name) {
            return [];
        }

        $className = $node->class->toString();

        if ($this->isSelfReference($className)) {
            return [];
        }

        if ($this->config->isExcepted($className)) {
            return [];
        }

        if ($node->name instanceof Identifier) {
            $methodName = $node->name->toString();

            if ($this->shouldIgnoreByPattern($methodName, $this->config->getMethodIgnorePattern())) {
                return [];
            }

            return [
                RuleErrorBuilder::message(
                    sprintf(self::ERROR_MESSAGE_TEMPLATE, $className, $methodName)
                )
                    ->identifier('MeliorStan.staticAccess')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * @return list<RuleError>
     */
    protected function processStaticPropertyFetch(StaticPropertyFetch $node): array
    {
        if (! $node->class instanceof Name) {
            return [];
        }

        $className = $node->class->toString();

        if ($this->isSelfReference($className)) {
            return [];
        }

        if ($this->config->isExcepted($className)) {
            return [];
        }

        if ($node->name instanceof Identifier) {
            $propertyName = $node->name->toString();

            if ($this->shouldIgnoreByPattern($propertyName, $this->config->getPropertyIgnorePattern())) {
                return [];
            }

            return [
                RuleErrorBuilder::message(
                    sprintf(self::ERROR_MESSAGE_TEMPLATE_PROPERTY, $className, $propertyName)
                )
                    ->identifier('MeliorStan.staticAccess')
                    ->build(),
            ];
        }

        return [];
    }

    protected function isSelfReference(string $className): bool
    {
        return isset(self::SELF_REFERENCES[strtolower($className)]);
    }

    protected function shouldIgnoreByPattern(string $name, string $pattern): bool
    {
        if ($pattern === '') {
            return false;
        }

        $result = @preg_match($pattern, $name);

        if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
            $error = preg_last_error_msg();

            throw new InvalidArgumentException(
                sprintf('Invalid regex pattern in ignore_pattern configuration: "%s". Error: %s', $pattern, $error)
            );
        }

        return $result === 1;
    }
}
