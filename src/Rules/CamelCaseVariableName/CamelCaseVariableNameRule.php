<?php

namespace Orrison\MeliorStan\Rules\CamelCaseVariableName;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Variable>
 */
class CamelCaseVariableNameRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Variable name "$%s" is not in camelCase.';

    protected string $pattern;

    /** @var string[] */
    protected array $ignoredVariables = [
        'php_errormsg',
        'http_response_header',
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

        // Skip PHP superglobals and special variables
        if (in_array($name, $this->ignoredVariables, true)) {
            return [];
        }

        // Only check variable definitions
        if ($node->getAttribute(VariableDefinitionVisitor::ATTRIBUTE_NAME) !== true) {
            return [];
        }

        if (! preg_match($this->pattern, $name)) {
            return [
                RuleErrorBuilder::message(
                    sprintf(self::ERROR_MESSAGE_TEMPLATE, $name)
                )
                    ->identifier('MeliorStan.variableNameNotCamelCase')
                    ->build(),
            ];
        }

        return [];
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
