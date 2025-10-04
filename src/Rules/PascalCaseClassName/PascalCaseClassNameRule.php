<?php

namespace Orrison\MeliorStan\Rules\PascalCaseClassName;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_>
 */
class PascalCaseClassNameRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE = 'Class name "%s" is not in PascalCase.';

    public function __construct(
        protected Config $config,
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

        // Default pattern: PascalCase (disallow consecutive uppercase, e.g., HTTPResponse is invalid, HttpResponse is valid)
        $pattern = '/^(?:[A-Z][a-z0-9]+)+$/';

        if ($this->config->allowConsecutiveUppercase()) {
            // Allow consecutive uppercase letters (e.g., HTTPResponse is valid)
            $pattern = '/^[A-Z][a-zA-Z0-9]*$/';
        }

        if ($node->name === null) {
            // If the class does not have a name, like for an anonymous class, we cannot validate it
            return [];
        }

        if (! preg_match($pattern, $node->name->name)) {
            $messages[] = RuleErrorBuilder::message(sprintf(self::ERROR_MESSAGE_TEMPLATE, $node->name->name))
                ->identifier('MeliorStan.classNameNotPascalCase')
                ->build();
        }

        return $messages;
    }
}
