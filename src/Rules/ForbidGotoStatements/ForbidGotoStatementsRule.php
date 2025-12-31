<?php

namespace Orrison\MeliorStan\Rules\ForbidGotoStatements;

use PhpParser\Node;
use PhpParser\Node\Stmt\Goto_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Goto_>
 */
class ForbidGotoStatementsRule implements Rule
{
    public const string ERROR_MESSAGE = 'Goto statements should not be used.';

    public function getNodeType(): string
    {
        return Goto_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(self::ERROR_MESSAGE)
                ->identifier('MeliorStan.gotoStatementForbidden')
                ->build(),
        ];
    }
}
