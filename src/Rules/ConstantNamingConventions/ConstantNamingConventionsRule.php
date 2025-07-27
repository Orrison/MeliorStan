<?php

namespace Orrison\MessedUpPhpstan\Rules\ConstantNamingConventions;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
final class ConstantNamingConventionsRule implements Rule
{
    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        // Handle ClassConst nodes (for classes, interfaces, enums)
        if ($node instanceof ClassConst) {
            foreach ($node->consts as $const) {
                $name = $const->name->name;

                // Check if constant name is all uppercase
                if ($name !== strtoupper($name)) {
                    $messages[] = RuleErrorBuilder::message(
                        sprintf('Constant name "%s" is not in UPPERCASE.', $name)
                    )->identifier('MessedUpPhpstan.constantNamingConventions')
                        ->build();
                }
            }
        }

        // Handle Trait_ nodes separately (for trait constants)
        if ($node instanceof Trait_) {
            foreach ($node->stmts as $stmt) {
                if ($stmt instanceof ClassConst) {
                    foreach ($stmt->consts as $const) {
                        $name = $const->name->name;

                        // Check if constant name is all uppercase
                        if ($name !== strtoupper($name)) {
                            $messages[] = RuleErrorBuilder::message(
                                sprintf('Constant name "%s" is not in UPPERCASE.', $name)
                            )->identifier('MessedUpPhpstan.constantNamingConventions')
                                ->line($const->getLine())
                                ->build();
                        }
                    }
                }
            }
        }

        return $messages;
    }
}
