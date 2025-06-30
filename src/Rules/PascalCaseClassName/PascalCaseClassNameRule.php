<?php

namespace Orrison\MessedUpPhpstan\Rules\PascalCaseClassName;

use Orrison\MessedUpPhpstan\Rules\PascalCaseClassName\Config;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_>
 */
final class PascalCaseClassNameRule implements Rule
{
    public function __construct(
        private Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        if (! $node instanceof Class_) {
            return $messages;
        }

        // Default pattern: PascalCase (allows consecutive uppercase, e.g., HTTPResponse)
        $pattern = '/^[A-Z][a-zA-Z0-9]*$/';

        if ($this->config->getPascalCaseAbbreviations()) {
            // Stricter: Disallow consecutive uppercase letters (e.g., HTTPResponse is invalid, HttpResponse is valid)
            // Each word must start with a single uppercase letter, followed by one or more lowercase/digits
            $pattern = '/^(?:[A-Z][a-z0-9]+)+$/';
        }

        if (! preg_match($pattern, $node->name->name)) {
            $messages[] = RuleErrorBuilder::message(sprintf('Class name "%s" is not in PascalCase.', $node->name->name))
                ->identifier('MessedUpPhpstan.classNameNotPascalCase')
                ->build();
        }

        return $messages;
    }
}
