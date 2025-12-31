<?php

namespace Orrison\MeliorStan\Rules\BooleanGetMethodName;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassMethod>
 */
class BooleanGetMethodNameRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Method "%s" starts with "get" and returns boolean, consider using "is" or "has" instead.';

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

        if ($this->isBooleanGetMethod($node)) {
            $methodName = $node->name->name;
            $messages[] = RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $methodName)
            )->identifier('MeliorStan.booleanGetMethodName')
                ->build();
        }

        return $messages;
    }

    protected function isBooleanGetMethod(ClassMethod $node): bool
    {
        return $this->isGetterMethodName($node)
            && $this->isReturnTypeBoolean($node)
            && $this->isParameterizedOrIgnored($node);
    }

    protected function isGetterMethodName(ClassMethod $node): bool
    {
        $methodName = $node->name->name;

        return preg_match('/^_?get/i', $methodName) > 0;
    }

    protected function isReturnTypeBoolean(ClassMethod $node): bool
    {
        // Check for explicit return type
        if ($node->returnType !== null) {
            if ($node->returnType instanceof Identifier) {
                $returnType = $node->returnType->name;

                return in_array($returnType, ['bool', 'true', 'false'], true);
            }

            if ($node->returnType instanceof Name) {
                $returnType = $node->returnType->toString();

                return in_array($returnType, ['bool', 'true', 'false'], true);
            }
        }

        // Check for @return annotation in docblock
        $docComment = $node->getDocComment();

        if ($docComment !== null) {
            $comment = $docComment->getText();

            return preg_match('/\*\s*@return\s+bool(ean)?\s/i', $comment) > 0;
        }

        return false;
    }

    protected function isParameterizedOrIgnored(ClassMethod $node): bool
    {
        if ($this->config->getCheckParameterizedMethods()) {
            // When true, check all methods (including those with parameters)
            return true;
        }

        // When false, only check methods with no parameters
        return count($node->params) === 0;
    }
}
