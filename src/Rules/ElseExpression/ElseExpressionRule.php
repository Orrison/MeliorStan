<?php

namespace Orrison\MeliorStan\Rules\ElseExpression;

use PhpParser\Node;
use PhpParser\Node\Stmt\If_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<If_>
 */
class ElseExpressionRule implements Rule
{
    public function __construct(
        protected Config $config,
    ) {}

    public function getNodeType(): string
    {
        return If_::class;
    }

    /**
     * @param If_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        if (! $this->config->getElseifAllowed()) {
            foreach ($node->elseifs as $elseif) {
                $errors[] = RuleErrorBuilder::message('Avoid using else expressions.')
                    ->identifier('MeliorStan.unnecessaryElse')
                    ->line($elseif->getStartLine())
                    ->build();
            }
        }

        if ($node->else !== null) {
            $errors[] = RuleErrorBuilder::message('Avoid using else expressions.')
                ->identifier('MeliorStan.unnecessaryElse')
                ->line($node->else->getStartLine())
                ->build();
        }

        return $errors;
    }
}
