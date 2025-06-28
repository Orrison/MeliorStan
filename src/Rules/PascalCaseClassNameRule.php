<?php

namespace Orrison\MessedUpPhpstan\Rules;

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
        if (! $node instanceof Class_) {
            return [];
        }

        var_dump($node);
        die();

        // $node->class

        // $node->get

        // $messages = [];

        // foreach ($node->params as $index => $param) {
        //     if (null !== $param->type || ! $param->var instanceof Node\Expr\Variable || ! is_string($param->var->name)) {
        //         continue;
        //     }

        //     $messages[] = RuleErrorBuilder::message(sprintf('Parameter #%d $%s of anonymous function has no typehint.', 1 + $index, $param->var->name))
        //         ->identifier('closure.parameterMissingTypehint')
        //         ->build();
        // }

        // return $messages;
    }
}
