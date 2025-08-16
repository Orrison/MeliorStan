<?php

namespace Orrison\MessStan\Rules\ShortMethodName;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassMethod>
 */
class ShortMethodNameRule implements Rule
{
    public function __construct(
        protected Config $config,
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

        $name = $node->name->name;

        // Early return for exceptions
        if (in_array($name, $this->config->getExceptions(), true)) {
            return $messages;
        }

        // Check if method name is shorter than minimum length
        if (strlen($name) < $this->config->getMinimumLength()) {
            $messages[] = RuleErrorBuilder::message(sprintf('Method name "%s" is shorter than minimum length of %d characters.', $name, $this->config->getMinimumLength()))
                ->identifier('MessStan.methodNameTooShort')
                ->build();
        }

        return $messages;
    }
}
