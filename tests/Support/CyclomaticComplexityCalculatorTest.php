<?php

namespace Orrison\MeliorStan\Tests\Support;

use Orrison\MeliorStan\Support\CyclomaticComplexityCalculator;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

class CyclomaticComplexityCalculatorTest extends TestCase
{
    protected CyclomaticComplexityCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new CyclomaticComplexityCalculator();
    }

    // Core functionality

    public function testEmptyMethodHasBaseComplexityOfOne(): void
    {
        $method = $this->parseMethod('public function foo(): void {}');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    public function testAbstractMethodHasBaseComplexityOfOne(): void
    {
        $method = $this->parseMethod('abstract public function foo(): void;');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    public function testIfStatementAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { echo "y"; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testElseIfAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { echo "y"; } elseif ($a < 0) { echo "n"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    public function testWhileLoopAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { while ($a > 0) { $a--; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testDoWhileLoopAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { do { $a--; } while ($a > 0); }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testForLoopAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(): void { for ($i = 0; $i < 3; $i++) { echo $i; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testForeachLoopAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(array $items): void { foreach ($items as $item) { echo $item; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testCatchClauseAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(): void { try { echo "ok"; } catch (\Exception $e) { echo "err"; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testTernaryAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(int $a): string { return $a > 0 ? "yes" : "no"; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testNullCoalesceAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(?int $a): int { return $a ?? 0; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testBooleanAndOperatorAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(bool $a, bool $b): bool { return $a && $b; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testBooleanOrOperatorAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(bool $a, bool $b): bool { return $a || $b; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testLogicalAndKeywordAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(bool $a, bool $b): bool { return $a and $b; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testLogicalOrKeywordAddsOne(): void
    {
        $method = $this->parseMethod('public function foo(bool $a, bool $b): bool { return $a or $b; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    // Switch / match edge cases

    public function testSwitchCaseAddsOnePerCase(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { switch ($a) { case 1: echo "one"; break; case 2: echo "two"; break; } }');
        $this->assertSame(3, $this->calculator->calculate($method)); // base + 2 cases
    }

    public function testSwitchDefaultCaseDoesNotAddComplexity(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { switch ($a) { default: echo "other"; } }');
        $this->assertSame(1, $this->calculator->calculate($method)); // only base
    }

    public function testSwitchWithCasesAndDefaultCountsOnlyCases(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { switch ($a) { case 1: echo "one"; break; case 2: echo "two"; break; default: echo "other"; } }');
        $this->assertSame(3, $this->calculator->calculate($method)); // base + 2 cases, default excluded
    }

    public function testMatchExpressionArmsAreNotCounted(): void
    {
        // match arms are not included in the complexity calculation; document actual behavior
        $method = $this->parseMethod('public function foo(int $a): string { return match($a) { 1 => "one", 2 => "two", default => "other" }; }');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    // Nested / combined

    public function testNestedConditionsAreEachCounted(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { if ($a > 10) { echo "big"; } } }');
        $this->assertSame(3, $this->calculator->calculate($method)); // base + outer if + inner if
    }

    public function testMultipleOperatorsInOneExpressionAreEachCounted(): void
    {
        $method = $this->parseMethod('public function foo(bool $a, bool $b, bool $c): bool { return $a && $b && $c; }');
        $this->assertSame(3, $this->calculator->calculate($method)); // base + 2x &&
    }

    public function testKnownComplexityElevenMethod(): void
    {
        $code = '
            public function process(int $a): void {
                if ($a > 0) {
                    if ($a > 10) { echo "big"; }
                    elseif ($a > 5) { echo "mid"; }
                } elseif ($a < 0) {
                    while ($a < 0) { $a++; }
                }
                for ($i = 0; $i < 3; $i++) { echo $i; }
                foreach ([1, 2] as $v) { echo $v; }
                $x = $a > 0 ? "yes" : "no";
                $y = $a ?? 0;
                if ($a === 100) { echo "exact"; }
            }
        ';
        $method = $this->parseMethod($code);
        $this->assertSame(11, $this->calculator->calculate($method));
    }

    // Helpers

    protected function parseMethod(string $methodCode): ClassMethod
    {
        $parser = (new ParserFactory())->createForHostVersion();
        $stmts = $parser->parse("<?php class Wrapper { {$methodCode} }");
        $nodeFinder = new NodeFinder();

        /** @var ClassMethod[] $methods */
        $methods = $nodeFinder->findInstanceOf($stmts ?? [], ClassMethod::class);

        return $methods[0];
    }
}
