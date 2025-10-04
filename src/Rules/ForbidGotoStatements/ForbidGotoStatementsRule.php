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
    public function getNodeType(): string
    {
        return Goto_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message('Goto statements should not be used.')
                ->identifier('MeliorStan.gotoStatementForbidden')
                ->build(),
        ];
    }
}
