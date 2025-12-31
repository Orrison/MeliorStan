<?php

namespace Orrison\MeliorStan\Rules\ConstructorWithNameAsEnclosingClass;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassMethod>
 */
class ConstructorWithNameAsEnclosingClassRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Method name "%s" is the same as the enclosing class "%s". This creates confusion as it resembles a PHP4-style constructor.';

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        $methodName = $node->name->name;

        // Skip if method is a constructor
        if ($methodName === '__construct') {
            return $messages;
        }

        $classReflection = $scope->getClassReflection();

        if ($classReflection === null) {
            return $messages; // Skip if no class context
        }

        // Skip if this is a trait or interface
        if ($classReflection->isTrait() || $classReflection->isInterface()) {
            return $messages;
        }

        $className = $classReflection->getName();

        // Extract short class name (without namespace)
        $shortClassName = $this->getShortClassName($className);

        // Check if method name matches class name (case-insensitive)
        if (strcasecmp($methodName, $shortClassName) === 0) {
            $messages[] = RuleErrorBuilder::message(
                sprintf(self::ERROR_MESSAGE_TEMPLATE, $methodName, $shortClassName)
            )
                ->identifier('MeliorStan.constructorWithNameAsEnclosingClass')
                ->build();
        }

        return $messages;
    }

    private function getShortClassName(string $fullClassName): string
    {
        $parts = explode('\\', $fullClassName);

        return $parts[count($parts) - 1];
    }
}
