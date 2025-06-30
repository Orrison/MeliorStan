<?php

namespace Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName;

use Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName\Config;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassMethod>
 */
final class CamelCaseMethodNameRule implements Rule
{
    private array $ignoredMethods = [
        '__construct',
        '__destruct',
        '__set',
        '__get',
        '__call',
        '__callStatic',
        '__isset',
        '__unset',
        '__sleep',
        '__wakeup',
        '__toString',
        '__invoke',
        '__set_state',
        '__clone',
        '__debugInfo',
        '__serialize',
        '__unserialize',
    ];

    public function __construct(
        private Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        if (! $node instanceof ClassMethod) {
            return $messages;
        }

        $name = $node->name->name;

        // Early return for ignored methods
        if (in_array($name, $this->ignoredMethods, true)) {
            return $messages;
        }

        // Build the base pattern for camelCase
        $basePattern = $this->config->getAllowConsecutiveUppercase()
            ? '[a-z][a-zA-Z0-9]*'
            : '[a-z](?:[a-z0-9]+|[A-Z][a-z0-9]+)*';

        // Allow optional single underscore prefix
        $prefix = $this->config->getAllowUnderscorePrefix() ? '_?' : '';

        // Allow underscores in test methods
        $suffix = '';
        if ($this->config->getAllowUnderscoreInTests() && str_starts_with($name, 'test')) {
            $suffix = '(_[a-zA-Z0-9]+)*';
        }

        $pattern = "/^{$prefix}{$basePattern}{$suffix}$/";

        if (! preg_match($pattern, $name)) {
            $messages[] = RuleErrorBuilder::message(sprintf('Method name "%s" is not in camelCase.', $name))
                ->identifier('MessedUpPhpstan.methodNameNotCamelCase')
                ->build();
        }

        return $messages;
    }
}
