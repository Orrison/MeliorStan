<?php

namespace Orrison\MessedUpPhpstan\Rules\TraitConstantNamingConventions;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Trait_>
 */
class TraitConstantNamingConventionsRule implements Rule
{
    /**
     * @return class-string<Trait_>
     */
    public function getNodeType(): string
    {
        return Trait_::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof ClassConst) {
                foreach ($stmt->consts as $const) {
                    $name = $const->name->name;

                    // Check if constant name is all uppercase
                    if ($name !== strtoupper($name)) {
                        $messages[] = RuleErrorBuilder::message(
                            sprintf('Constant name "%s" is not in UPPERCASE.', $name)
                        )->identifier('MessedUpPhpstan.traitConstantNamingConventions')
                            ->line($const->getLine())
                            ->build();
                    }
                }
            }
        }

        return $messages;
    }
}
