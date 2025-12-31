<?php

namespace Orrison\MeliorStan\Rules\MissingClosureParameterTypehint;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Closure>
 */
class MissingClosureParameterTypehintRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Parameter #%d $%s of anonymous function has no typehint.';

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Closure::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        foreach ($node->params as $index => $param) {
            if (null !== $param->type || ! $param->var instanceof Variable || ! is_string($param->var->name)) {
                continue;
            }

            $messages[] = RuleErrorBuilder::message(sprintf(self::ERROR_MESSAGE_TEMPLATE, 1 + $index, $param->var->name))
                ->identifier('MeliorStan.closureParameterMissingTypehint')
                ->build();
        }

        return $messages;
    }
}
