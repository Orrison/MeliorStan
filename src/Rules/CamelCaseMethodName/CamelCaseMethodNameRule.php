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

        // Allow consecutive uppercase letters (e.g., getHTTPResponse)
        if ($this->config->getAllowConsecutiveUppercase()) {
            $pattern = '/^[a-z][a-zA-Z0-9]*$/';
        } else {
            // Disallow consecutive uppercase (e.g., getHTTPResponse is invalid, getHttpResponse is valid)
            $pattern = '/^[a-z](?:[a-z0-9]+|[A-Z][a-z0-9]+)*$/';
        }

        // Allow underscore prefix
        if ($this->config->getAllowUnderscorePrefix()) {
            $pattern = '/^_?' . substr($pattern, 1);
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
