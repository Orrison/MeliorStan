<?php

namespace Orrison\MessedUpPhpstan\Rules\ConstantNamingConventions;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassConst>
 */
class ConstantNamingConventionsRule implements Rule
{
    /**
     * @return class-string<ClassConst>
     */
    public function getNodeType(): string
    {
        return ClassConst::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

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

        return $messages;
    }
}
