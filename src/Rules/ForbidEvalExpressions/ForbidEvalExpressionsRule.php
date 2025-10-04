<?php

namespace Orrison\MeliorStan\Rules\ForbidEvalExpressions;

use PhpParser\Node;
use PhpParser\Node\Expr\Eval_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Eval_>
 */
class ForbidEvalExpressionsRule implements Rule
{
    public function getNodeType(): string
    {
        return Eval_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message('Eval expressions should not be used.')
                ->identifier('MeliorStan.evalExpressionsForbidden')
                ->build(),
        ];
    }
}
