<?php

namespace Orrison\MessedUpPhpstan\Rules\CamelCasePropertyName;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Property>
 */
final class CamelCasePropertyNameRule implements Rule
{
    public function __construct(
        private Config $config,
    ) {
    }

    /**
     * @return class-string<Node>
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
        $messages = [];

        if (! $node instanceof Property) {
            return $messages;
        }

        foreach ($node->props as $prop) {
            $name = $prop->name->name;

            if (! preg_match($this->buildRegexPattern(), $name)) {
                $messages[] = RuleErrorBuilder::message(
                    sprintf('Property name "%s" is not in camelCase.', $prop->name->name)
                )->build();
            }
        }

        return $messages;
    }

    protected function buildRegexPattern(): string
    {
        $pattern = '/^';

        $pattern .= $this->config->getAllowUnderscorePrefix()
            ? '_?'
            : '';

        $pattern .= '[a-z]';

        $pattern .= $this->config->getAllowConsecutiveUppercase()
            ? '[a-zA-Z0-9]*'
            : '(?:[a-z0-9]+|[A-Z][a-z0-9]+)*';

        $pattern .= '$/';

        return $pattern;
    }
}
