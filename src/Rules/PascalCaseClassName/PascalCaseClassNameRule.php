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

        $pattern = '/^[A-Z][a-zA-Z0-9]*$/';

        if ($this->config->getCamelcaseAbbreviations()) {
            // disallow any consecutive uppercase letters
            // e.g. "HTTPResponse" is not allowed, but "HttpResponse" is allowed
            $pattern = '/^([A-Z][a-z0-9]+)*$/';
        }

        if (! preg_match($pattern, $node->name->name)) {
            $messages[] = RuleErrorBuilder::message(sprintf('Class name "%s" is not in PascalCase.', $node->name->name))
                ->identifier('MessedUpPhpstan.classNameNotPascalCase')
                ->build();
        }

        return $messages;
    }
}
