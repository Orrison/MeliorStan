<?php

namespace Orrison\MeliorStan\Rules\CamelCaseParameterName;

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
class CamelCaseParameterNameRule implements Rule
{
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
        return Param::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        $var = $node->var;

        if (! $var instanceof Variable) {
            return $messages;
        }

        $name = is_string($var->name) ? $var->name : null;

        if ($name !== null && ! preg_match($this->pattern, $name)) {
            $messages[] = RuleErrorBuilder::message(
                sprintf('Parameter name "%s" is not in camelCase.', $name)
            )->build();
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
            : '(?:[a-z0-9]+(?:[A-Z](?![A-Z])[a-z0-9]*)*)?';

        $pattern .= '$/';

        return $pattern;
    }
}
