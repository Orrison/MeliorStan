<?php

namespace Orrison\MeliorStan\Rules\ErrorControlOperator;

use PhpParser\Node;
use PhpParser\Node\Expr\ErrorSuppress;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ErrorSuppress>
 */
class ErrorControlOperatorRule implements Rule
{
    public const string ERROR_MESSAGE = 'Use of the error control operator (@) is not allowed.';

    public function getNodeType(): string
    {
        return ErrorSuppress::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(self::ERROR_MESSAGE)
                ->identifier('MeliorStan.errorControlOperatorUsed')
                ->build(),
        ];
    }
}
