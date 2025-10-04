<?php

namespace Orrison\MeliorStan\Rules\Superglobals;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Variable>
 */
class SuperglobalsRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE = 'Superglobal "$%s" should not be used.';

    /** @var string[] */
    protected array $superglobals = [
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
                    sprintf(self::ERROR_MESSAGE_TEMPLATE, $name)
                )->identifier('MeliorStan.superglobalUsage')
                    ->build(),
            ];
        }

        return [];
    }
}
