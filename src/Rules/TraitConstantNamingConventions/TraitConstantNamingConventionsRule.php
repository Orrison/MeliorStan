<?php

namespace Orrison\MeliorStan\Rules\TraitConstantNamingConventions;

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
    public const string ERROR_MESSAGE_TEMPLATE = 'Constant name "%s" is not in UPPERCASE.';

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
                            sprintf(self::ERROR_MESSAGE_TEMPLATE, $name)
                        )->identifier('MeliorStan.traitConstantNamingConventions')
                            ->line($const->getLine())
                            ->build();
                    }
                }
            }
        }

        return $messages;
    }
}
