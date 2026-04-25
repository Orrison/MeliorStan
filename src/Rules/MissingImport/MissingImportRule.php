<?php

namespace Orrison\MeliorStan\Rules\MissingImport;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\IntersectionType;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class MissingImportRule implements Rule
{
    public const string ERROR_MESSAGE_TEMPLATE = 'Class "\\%s" should not be referenced by its fully qualified name. Import it with a "use" statement instead.';

    public function __construct(
        protected Config $config,
    ) {}

    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @return list<RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        // --- Type annotation positions ---

        // Parameter types: function foo(\Foo\Bar $x)
        if ($node instanceof Param) {
            return $this->buildErrors($this->extractFqcnsFromType($node->type));
        }

        // Property types: private \Foo\Bar $prop;
        if ($node instanceof Property) {
            return $this->buildErrors($this->extractFqcnsFromType($node->type));
        }

        // Return types: function foo(): \Foo\Bar
        if ($node instanceof ClassMethod
            || $node instanceof Function_
            || $node instanceof Closure
            || $node instanceof ArrowFunction) {
            return $this->buildErrors($this->extractFqcnsFromType($node->returnType));
        }

        // --- Expression positions ---

        // new \Foo\Bar()  /  $x instanceof \Foo\Bar
        if (($node instanceof New_ || $node instanceof Instanceof_)
            && $node->class instanceof FullyQualified
            && $this->isExplicitFqcn($node->class)) {
            return $this->buildErrors([$node->class->toString()]);
        }

        // \Foo\Bar::method()  /  \Foo\Bar::$prop  /  \Foo\Bar::CONST
        if (($node instanceof StaticCall
            || $node instanceof StaticPropertyFetch
            || $node instanceof ClassConstFetch)
            && $node->class instanceof FullyQualified
            && $this->isExplicitFqcn($node->class)) {
            return $this->buildErrors([$node->class->toString()]);
        }

        // --- Class declaration positions ---

        // class Foo extends \Bar implements \Baz
        // interface Foo extends \Bar
        // enum Foo implements \Bar
        if ($node instanceof InClassNode) { // @phpstan-ignore phpstanApi.instanceofAssumption
            $classLike = $node->getOriginalNode();
            $fqcns = [];

            if ($classLike instanceof Class_) {
                if ($classLike->extends instanceof FullyQualified && $this->isExplicitFqcn($classLike->extends)) {
                    $fqcns[] = $classLike->extends->toString();
                }

                foreach ($classLike->implements as $interface) {
                    if ($interface instanceof FullyQualified && $this->isExplicitFqcn($interface)) {
                        $fqcns[] = $interface->toString();
                    }
                }
            } elseif ($classLike instanceof Interface_) {
                foreach ($classLike->extends as $extend) {
                    if ($extend instanceof FullyQualified && $this->isExplicitFqcn($extend)) {
                        $fqcns[] = $extend->toString();
                    }
                }
            } elseif ($classLike instanceof Enum_) {
                foreach ($classLike->implements as $interface) {
                    if ($interface instanceof FullyQualified && $this->isExplicitFqcn($interface)) {
                        $fqcns[] = $interface->toString();
                    }
                }
            }

            return $this->buildErrors($fqcns);
        }

        // catch (\Foo\Bar $e) — types is a Name[]
        if ($node instanceof Catch_) {
            $fqcns = array_values(array_map(
                fn (Name $type): string => $type->toString(),
                array_filter(
                    $node->types,
                    fn (Name $type): bool => $type instanceof FullyQualified && $this->isExplicitFqcn($type)
                )
            ));

            return $this->buildErrors($fqcns);
        }

        return [];
    }

    /**
     * Extracts all explicitly-written FullyQualified names from a type node,
     * recursively unwrapping union, intersection, and nullable types.
     *
     * @return string[]
     */
    protected function extractFqcnsFromType(Node|null $type): array
    {
        if ($type === null) {
            return [];
        }

        if ($type instanceof FullyQualified && $this->isExplicitFqcn($type)) {
            return [$type->toString()];
        }

        if ($type instanceof UnionType || $type instanceof IntersectionType) {
            $fqcns = [];

            foreach ($type->types as $part) {
                $fqcns = array_merge($fqcns, $this->extractFqcnsFromType($part));
            }

            return $fqcns;
        }

        if ($type instanceof NullableType) {
            return $this->extractFqcnsFromType($type->type);
        }

        return [];
    }

    /**
     * Returns true when the FullyQualified name was explicitly written with a
     * leading backslash in source code, rather than being resolved from an
     * imported (shorter) name by PHPStan's NameResolver.
     *
     * When NameResolver resolves an unqualified name (e.g. `SomeService` after
     * `use App\Services\SomeService`) it sets the `originalName` attribute on
     * the resulting FullyQualified node to the original unqualified Name node.
     * An already-FullyQualified name written in source has no `originalName`.
     */
    protected function isExplicitFqcn(FullyQualified $node): bool
    {
        $originalName = $node->getAttribute('originalName');

        // If originalName is a plain Name (not itself FullyQualified), the
        // reference was resolved from an import — not an explicit FQCN.
        return ! ($originalName instanceof Name && ! $originalName instanceof FullyQualified);
    }

    /**
     * @param string[] $classNames
     *
     * @return list<RuleError>
     */
    protected function buildErrors(array $classNames): array
    {
        $errors = [];

        foreach ($classNames as $className) {
            // Skip global-namespace classes (no backslash in the name)
            if ($this->config->getIgnoreGlobal() && ! str_contains($className, '\\')) {
                continue;
            }

            // Skip explicitly allowed classes
            if (in_array($className, $this->config->getExceptions(), true)) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(sprintf(self::ERROR_MESSAGE_TEMPLATE, $className))
                ->identifier('MeliorStan.missingImport')
                ->build();
        }

        return $errors;
    }
}
