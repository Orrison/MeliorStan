<?php

namespace Orrison\MessedUpPhpstan\Rules\Superglobals;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Variable>
 */
final class SuperglobalsRule implements Rule
{
    /** @var string[] */
    private array $superglobals = [
        'GLOBALS',
        '_SERVER',
        '_GET',
        '_POST',
        '_FILES',
        '_COOKIE',
        '_SESSION',
        '_REQUEST',
        '_ENV',
    ];

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Variable::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        // Skip variables with non-string names (dynamic variables like $$var)
        if (! is_string($node->name)) {
            return [];
        }

        $name = $node->name;

        // Check if this is a superglobal
        if (in_array($name, $this->superglobals, true)) {
            return [
                RuleErrorBuilder::message(
                    sprintf('Superglobal "$%s" should not be used in userland code.', $name)
                )->identifier('MessedUpPhpstan.superglobalUsage')
                    ->build(),
            ];
        }

        return [];
    }
}
