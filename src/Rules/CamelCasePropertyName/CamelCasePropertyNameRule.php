<?php

namespace Orrison\MeliorStan\Rules\CamelCasePropertyName;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Property>
 */
class CamelCasePropertyNameRule implements Rule
{
    public const ERROR_MESSAGE_TEMPLATE = 'Property name "%s" is not in camelCase.';

    protected string $pattern;

    public function __construct(
        protected Config $config,
    ) {
        $this->pattern = $this->buildRegexPattern();
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

        // Check if the current class should be ignored
        $classReflection = $scope->getClassReflection();

        if ($classReflection === null) {
            return $messages; // Skip if no class context
        }

        $className = $classReflection->getName();

        // Ignore if class is in the ignored classes list
        if (in_array($className, $this->config->getIgnoredWhenInClasses(), true)) {
            return $messages;
        }

        // Ignore if class extends any ignored parent class
        foreach ($this->config->getIgnoredWhenInClassesDescendantOf() as $ignoredParent) {
            if ($classReflection->isSubclassOf((string) $ignoredParent) || $className === (string) $ignoredParent) {
                return $messages;
            }
        }

        foreach ($node->props as $prop) {
            $name = $prop->name->name;

            if (! preg_match($this->pattern, $name)) {
                $messages[] = RuleErrorBuilder::message(
                    sprintf(self::ERROR_MESSAGE_TEMPLATE, $prop->name->name)
                )
                    ->identifier('MeliorStan.propertyNameNotCamelCase')
                    ->build();
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
            : '(?:[a-z0-9]+(?:[A-Z](?![A-Z])[a-z0-9]*)*)';

        $pattern .= '$/';

        return $pattern;
    }
}
