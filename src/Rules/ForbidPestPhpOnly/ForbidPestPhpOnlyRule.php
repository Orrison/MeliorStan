<?php

namespace Orrison\MeliorStan\Rules\ForbidPestPhpOnly;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<MethodCall>
 */
class ForbidPestPhpOnlyRule implements Rule
{
    public const ERROR_MESSAGE = 'Pest\'s only() filter should not be used in committed tests.';

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $methodName = $node->name;

        if (! $methodName instanceof Identifier || $methodName->toString() !== 'only') {
            return [];
        }

        $filePath = $scope->getFile();

        if ($filePath === '' || ! $this->isTestFile($filePath)) {
            return [];
        }

        return [
            RuleErrorBuilder::message(self::ERROR_MESSAGE)
                ->identifier('MeliorStan.forbidPestPhpOnly')
                ->build(),
        ];
    }

    protected function isTestFile(string $filePath): bool
    {
        $normalized = str_replace('\\', '/', $filePath);
        $fileName = basename($normalized);

        if (preg_match('#/(tests|Tests)/#', $normalized) === 1) {
            return true;
        }

        if (str_ends_with($fileName, 'Test.php')) {
            return true;
        }

        return strcasecmp($fileName, 'Pest.php') === 0;
    }
}
