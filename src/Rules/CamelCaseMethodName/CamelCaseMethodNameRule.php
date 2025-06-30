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
        '__construct', '__destruct', '__call', '__callStatic', '__get', '__set', '__isset', '__unset',
        '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo',
        // Add more if PHP adds more magic methods in the future
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
        $pattern = '/^[a-z][a-zA-Z0-9]*$/';

        // Early return for ignored methods
        if (in_array($name, $this->ignoredMethods, true)) {
            return $messages;
        }

        // Allow consecutive uppercase letters (e.g., getHTTPResponse)
        if ($this->config->getAllowConsecutiveUppercase()) {
            $basePattern = '[a-z][a-zA-Z0-9]*';
        } else {
            // Disallow consecutive uppercase (e.g., getHTTPResponse is invalid, getHttpResponse is valid)
            $basePattern = '[a-z](?:[a-z0-9]+|[A-Z][a-z0-9]+)*';
        }

        // Allow underscore prefix
        if ($this->config->getAllowUnderscorePrefix()) {
            $pattern = '/^_?' . $basePattern . '$/';
        } else {
            $pattern = '/^' . $basePattern . '$/';
        }

        // Allow underscores in test methods
        if ($this->config->getAllowUnderscoreInTests() && str_starts_with($name, 'test')) {
            $pattern = str_replace('$', '(_[a-zA-Z0-9]+)*$', $pattern);
        }

        if (! preg_match($pattern, $name)) {
            $messages[] = RuleErrorBuilder::message(sprintf('Method name "%s" is not in camelCase.', $name))
                ->identifier('MessedUpPhpstan.methodNameNotCamelCase')
                ->build();
        }

        return $messages;
    }
}
