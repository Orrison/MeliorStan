<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortProperty;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Property>
 */
class ShortPropertyRule implements Rule
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
     * @return class-string<Property>
     */
    public function getNodeType(): string
    {
        return Property::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        foreach ($node->props as $prop) {
            $name = $prop->name->name;

            // Check if property is in exceptions list using O(1) lookup
            if (isset($this->exceptionsSet[$name])) {
                continue;
            }

            if (strlen($name) < $this->minimumLength) {
                $errors[] = RuleErrorBuilder::message(
                    sprintf('Property name "$%s" is shorter than minimum length of %d characters.', $name, $this->minimumLength)
                )->identifier('MessedUpPhpstan.shortProperty')
                    ->build();
            }
        }

        return $errors;
    }
}
