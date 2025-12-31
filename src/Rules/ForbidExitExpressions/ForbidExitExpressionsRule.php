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
    public const string ERROR_MESSAGE = 'Exit expressions should not be used.';

    public function getNodeType(): string
    {
        return Exit_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(self::ERROR_MESSAGE)
                ->identifier('MeliorStan.exitExpressionsForbidden')
                ->build(),
        ];
    }
}
