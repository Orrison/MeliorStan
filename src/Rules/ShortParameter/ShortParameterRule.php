<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortParameter;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Param>
 */
class ShortParameterRule implements Rule
{
    /** @var array<string, int|string> Cached exceptions list as a set for O(1) lookups */
    protected array $exceptionsSet = [];

    protected int $minimumLength;

    public function __construct(
        protected Config $config,
    ) {
        // Cache config values for efficiency
        $this->minimumLength = $this->config->getMinimumLength();

        // Convert exceptions array to set for O(1) lookups
        $this->exceptionsSet = array_flip($this->config->getExceptions());
    }

    /**
     * @return class-string<Param>
     */
    public function getNodeType(): string
    {
        return Param::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->var instanceof Variable || ! is_string($node->var->name)) {
            return [];
        }

        $name = $node->var->name;

        // Check if parameter is in exceptions list using O(1) lookup
        if (isset($this->exceptionsSet[$name])) {
            return [];
        }

        if (strlen($name) < $this->minimumLength) {
            return [
                RuleErrorBuilder::message(
                    sprintf('Parameter name "$%s" is shorter than minimum length of %d characters.', $name, $this->minimumLength)
                )->identifier('MessedUpPhpstan.shortParameter')
                    ->build(),
            ];
        }

        return [];
    }
}
