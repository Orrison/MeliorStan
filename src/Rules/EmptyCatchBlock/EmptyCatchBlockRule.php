<?php

namespace Orrison\MeliorStan\Rules\EmptyCatchBlock;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Nop;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Catch_>
 */
class EmptyCatchBlockRule implements Rule
{
    public function getNodeType(): string
    {
        return Catch_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->isEmpty($node->stmts)) {
            return [
                RuleErrorBuilder::message('Empty catch block detected. Catch blocks should contain error handling logic.')
                    ->identifier('MeliorStan.emptyCatchBlock')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * @param Stmt[] $stmts
     */
    private function isEmpty(array $stmts): bool
    {
        if (count($stmts) === 0) {
            return true;
        }

        // Check if all statements are just Nop (comments/whitespace)
        foreach ($stmts as $stmt) {
            if (! $stmt instanceof Nop) {
                return false;
            }
        }

        return true;
    }
}
