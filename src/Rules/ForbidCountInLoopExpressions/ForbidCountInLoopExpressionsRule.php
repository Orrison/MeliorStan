<?php

namespace Orrison\MeliorStan\Rules\ForbidCountInLoopExpressions;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\While_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Stmt>
 */
class ForbidCountInLoopExpressionsRule implements Rule
{
    public function getNodeType(): string
    {
        return Stmt::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof For_
            && ! $node instanceof While_
            && ! $node instanceof Do_
        ) {
            return [];
        }

        return $this->checkLoopConditions($node);
    }

    /**
     * @return list<IdentifierRuleError>
     */
    private function checkLoopConditions(Stmt $loop): array
    {
        $conditions = $this->getConditionExpressions($loop);
        $errors = [];

        foreach ($conditions as $condition) {
            $countCall = $this->findFirstCountCall($condition);

            if ($countCall !== null) {
                $errors[] = RuleErrorBuilder::message(
                    'Using count() or sizeof() in loop conditions can cause performance issues or hard to trace bugs.'
                )
                    ->identifier('MeliorStan.countInLoopExpression')
                    ->line($countCall->getLine())
                    ->build();

                // Only report the first occurrence per loop
                break;
            }
        }

        return $errors;
    }

    /**
     * @return Expr[]
     */
    private function getConditionExpressions(Stmt $loop): array
    {
        if ($loop instanceof For_) {
            return $loop->cond;
        }

        if ($loop instanceof While_) {
            return [$loop->cond];
        }

        if ($loop instanceof Do_) {
            return [$loop->cond];
        }

        return [];
    }

    private function findFirstCountCall(Expr $expr): ?FuncCall
    {
        if ($expr instanceof FuncCall && $this->isCountOrSizeof($expr->name)) {
            return $expr;
        }

        foreach ($expr->getSubNodeNames() as $subNodeName) {
            $subNode = $expr->$subNodeName;

            if ($subNode instanceof Expr) {
                $result = $this->findFirstCountCall($subNode);

                if ($result !== null) {
                    return $result;
                }
            } elseif (is_array($subNode)) {
                foreach ($subNode as $item) {
                    if ($item instanceof Expr) {
                        $result = $this->findFirstCountCall($item);

                        if ($result !== null) {
                            return $result;
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param Name|Expr $name
     */
    private function isCountOrSizeof($name): bool
    {
        if (! $name instanceof Name) {
            return false;
        }

        $functionName = $name->toLowerString();

        return $functionName === 'count' || $functionName === 'sizeof';
    }
}
