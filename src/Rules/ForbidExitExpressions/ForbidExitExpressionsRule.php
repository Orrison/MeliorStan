<?php

namespace Orrison\MeliorStan\Rules\ForbidExitExpressions;

use PhpParser\Node;
use PhpParser\Node\Expr\Exit_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Exit_>
 */
class ForbidExitExpressionsRule implements Rule
{
    public function getNodeType(): string
    {
        return Exit_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message('Exit expressions should not be used.')
                ->identifier('MeliorStan.exitExpressionsForbidden')
                ->build(),
        ];
    }
}
