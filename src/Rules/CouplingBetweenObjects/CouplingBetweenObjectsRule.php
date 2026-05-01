<?php

namespace Orrison\MeliorStan\Rules\CouplingBetweenObjects;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\IntersectionType;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\UnionType;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class CouplingBetweenObjectsRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = '%s "%s" has a coupling between objects value of %d, which exceeds the maximum of %d. Consider reducing dependencies.';

    /** @var array<string, true> */
    protected const array BUILTIN_TYPES = [
        'int' => true,
        'integer' => true,
        'float' => true,
        'double' => true,
        'string' => true,
        'bool' => true,
        'boolean' => true,
        'array' => true,
        'object' => true,
        'mixed' => true,
        'void' => true,
        'null' => true,
        'never' => true,
        'callable' => true,
        'iterable' => true,
        'self' => true,
        'static' => true,
        'parent' => true,
        'true' => true,
        'false' => true,
    ];

    public function __construct(
        protected Config $config,
    ) {}

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @param ClassLike $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Identifier) {
            return [];
        }

        $coupledTypes = $this->collectCoupledTypes($node);

        $ownName = $this->resolveOwnClassName($node);
        $filteredTypes = $this->filterTypes($coupledTypes, $ownName);

        $count = count($filteredTypes);

        if ($count <= $this->config->getMaximum()) {
            return [];
        }

        $nodeType = $this->getNodeTypeName($node);

        return [
            RuleErrorBuilder::message(
                sprintf(
                    self::ERROR_MESSAGE_TEMPLATE,
                    $nodeType,
                    $node->name->toString(),
                    $count,
                    $this->config->getMaximum()
                )
            )
                ->identifier('MeliorStan.couplingBetweenObjects')
                ->build(),
        ];
    }

    /**
     * @return array<string, true>
     */
    protected function collectCoupledTypes(ClassLike $node): array
    {
        $types = [];
        $nodeFinder = new NodeFinder();

        // extends / implements
        $this->collectInheritanceTypes($node, $types);

        // Trait uses
        foreach ($node->getTraitUses() as $traitUse) {
            foreach ($traitUse->traits as $trait) {
                $types[$trait->toString()] = true;
            }
        }

        // Property types
        foreach ($nodeFinder->findInstanceOf($node->stmts, Property::class) as $property) {
            $this->collectFromTypeNode($property->type, $types);
        }

        // Method parameter types and return types
        foreach ($nodeFinder->findInstanceOf($node->stmts, ClassMethod::class) as $method) {
            foreach ($method->params as $param) {
                $this->collectFromTypeNode($param->type, $types);
            }

            $this->collectFromTypeNode($method->returnType, $types);
        }

        // Closure parameter types and return types
        foreach ($nodeFinder->findInstanceOf($node->stmts, Closure::class) as $closure) {
            foreach ($closure->params as $param) {
                $this->collectFromTypeNode($param->type, $types);
            }

            $this->collectFromTypeNode($closure->returnType, $types);
        }

        // Arrow function parameter types and return types
        foreach ($nodeFinder->findInstanceOf($node->stmts, ArrowFunction::class) as $arrowFunction) {
            foreach ($arrowFunction->params as $param) {
                $this->collectFromTypeNode($param->type, $types);
            }

            $this->collectFromTypeNode($arrowFunction->returnType, $types);
        }

        // new ClassName()
        foreach ($nodeFinder->findInstanceOf($node->stmts, New_::class) as $newExpr) {
            if ($newExpr->class instanceof Name) {
                $types[$newExpr->class->toString()] = true;
            }
        }

        // ClassName::method()
        foreach ($nodeFinder->findInstanceOf($node->stmts, StaticCall::class) as $staticCall) {
            if ($staticCall->class instanceof Name) {
                $types[$staticCall->class->toString()] = true;
            }
        }

        // ClassName::$prop
        foreach ($nodeFinder->findInstanceOf($node->stmts, StaticPropertyFetch::class) as $staticPropFetch) {
            if ($staticPropFetch->class instanceof Name) {
                $types[$staticPropFetch->class->toString()] = true;
            }
        }

        // ClassName::CONST
        foreach ($nodeFinder->findInstanceOf($node->stmts, ClassConstFetch::class) as $constFetch) {
            if ($constFetch->class instanceof Name) {
                $types[$constFetch->class->toString()] = true;
            }
        }

        // catch (Type $e)
        foreach ($nodeFinder->findInstanceOf($node->stmts, Catch_::class) as $catch) {
            foreach ($catch->types as $catchType) {
                $types[$catchType->toString()] = true;
            }
        }

        // instanceof Type
        foreach ($nodeFinder->findInstanceOf($node->stmts, Instanceof_::class) as $instanceOf) {
            if ($instanceOf->class instanceof Name) {
                $types[$instanceOf->class->toString()] = true;
            }
        }

        // PHP 8 attributes
        if ($this->config->getCountAttributes()) {
            foreach ($nodeFinder->findInstanceOf($node->stmts, Attribute::class) as $attribute) {
                $types[$attribute->name->toString()] = true;
            }

            // Also check class-level attributes
            foreach ($node->attrGroups as $attrGroup) {
                foreach ($attrGroup->attrs as $attribute) {
                    $types[$attribute->name->toString()] = true;
                }
            }
        }

        return $types;
    }

    /**
     * @param array<string, true> $types
     */
    protected function collectInheritanceTypes(ClassLike $node, array &$types): void
    {
        if ($node instanceof Class_) {
            if ($node->extends !== null) {
                $types[$node->extends->toString()] = true;
            }

            foreach ($node->implements as $implement) {
                $types[$implement->toString()] = true;
            }
        }

        if ($node instanceof Interface_) {
            foreach ($node->extends as $extend) {
                $types[$extend->toString()] = true;
            }
        }

        if ($node instanceof Enum_) {
            foreach ($node->implements as $implement) {
                $types[$implement->toString()] = true;
            }
        }
    }

    /**
     * @param array<string, true> $types
     */
    protected function collectFromTypeNode(?Node $typeNode, array &$types): void
    {
        if ($typeNode === null) {
            return;
        }

        if ($typeNode instanceof Name) {
            $types[$typeNode->toString()] = true;

            return;
        }

        if ($typeNode instanceof Identifier) {
            // Built-in types like int, string, etc. - will be filtered later
            return;
        }

        if ($typeNode instanceof NullableType) {
            $this->collectFromTypeNode($typeNode->type, $types);

            return;
        }

        if ($typeNode instanceof UnionType) {
            foreach ($typeNode->types as $innerType) {
                $this->collectFromTypeNode($innerType, $types);
            }

            return;
        }

        if ($typeNode instanceof IntersectionType) {
            foreach ($typeNode->types as $innerType) {
                $this->collectFromTypeNode($innerType, $types);
            }
        }
    }

    /**
     * @param array<string, true> $types
     *
     * @return array<string, true>
     */
    protected function filterTypes(array $types, string $ownClassName): array
    {
        $excludedNamespaces = $this->config->getExcludedNamespaces();
        $excludedTypes = array_flip($this->config->getExcludedTypes());

        foreach ($types as $typeName => $_) {
            $lowerType = strtolower($typeName);

            // Filter built-in types
            if (isset(self::BUILTIN_TYPES[$lowerType])) {
                unset($types[$typeName]);

                continue;
            }

            // Filter self-references
            if ($typeName === $ownClassName) {
                unset($types[$typeName]);

                continue;
            }

            // Filter excluded types
            if (isset($excludedTypes[$typeName])) {
                unset($types[$typeName]);

                continue;
            }

            // Filter excluded namespaces
            foreach ($excludedNamespaces as $namespace) {
                if (str_starts_with($typeName, $namespace)) {
                    unset($types[$typeName]);

                    break;
                }
            }
        }

        return $types;
    }

    protected function resolveOwnClassName(ClassLike $node): string
    {
        if (isset($node->namespacedName)) {
            return $node->namespacedName->toString();
        }

        if ($node->name instanceof Identifier) {
            return $node->name->toString();
        }

        return '';
    }

    protected function getNodeTypeName(ClassLike $node): string
    {
        if ($node instanceof Class_) {
            return 'Class';
        }

        if ($node instanceof Interface_) {
            return 'Interface';
        }

        if ($node instanceof Trait_) {
            return 'Trait';
        }

        if ($node instanceof Enum_) {
            return 'Enum';
        }

        return 'Class';
    }
}
