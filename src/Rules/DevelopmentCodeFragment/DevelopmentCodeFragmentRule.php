<?php

namespace Orrison\MeliorStan\Rules\DevelopmentCodeFragment;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
class DevelopmentCodeFragmentRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Call to development/debug function %s() is discouraged.';

    public function __construct(
        protected Config $config,
    ) {}

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Name) {
            return [];
        }

        $functionName = $node->name->toLowerString();

        $unwantedFunctions = array_map('strtolower', $this->config->getUnwantedFunctions());

        if (! in_array($functionName, $unwantedFunctions, true)) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $functionName)
            )
                ->identifier('MeliorStan.developmentCodeFragment')
                ->build(),
        ];
    }
}
