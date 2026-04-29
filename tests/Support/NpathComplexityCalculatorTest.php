<?php

namespace Orrison\MeliorStan\Tests\Support;

use Orrison\MeliorStan\Support\NpathComplexityCalculator;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

class NpathComplexityCalculatorTest extends TestCase
{
    protected NpathComplexityCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new NpathComplexityCalculator();
    }

    // ── Base cases ────────────────────────────────────────────────────────────

    public function testEmptyMethodHasNpathOfOne(): void
    {
        $method = $this->parseMethod('public function foo(): void {}');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    public function testAbstractMethodHasNpathOfOne(): void
    {
        $method = $this->parseMethod('abstract public function foo(): void;');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    public function testSingleSimpleStatementHasNpathOfOne(): void
    {
        $method = $this->parseMethod('public function foo(): void { echo "hello"; }');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    // ── if statements ─────────────────────────────────────────────────────────

    public function testSimpleIfWithoutElseGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { echo "y"; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testSimpleIfElseGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { echo "y"; } else { echo "n"; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testIfElseifNoElseGivesNpathThree(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { echo "pos"; } elseif ($a < 0) { echo "neg"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    public function testIfElseifElseGivesNpathThree(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { if ($a > 0) { echo "pos"; } elseif ($a < 0) { echo "neg"; } else { echo "zero"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    public function testIfWithAndConditionAddsOnePath(): void
    {
        $method = $this->parseMethod('public function foo(int $a, int $b): void { if ($a > 0 && $b > 0) { echo "both"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    public function testIfWithOrConditionAddsOnePath(): void
    {
        $method = $this->parseMethod('public function foo(int $a, int $b): void { if ($a > 0 || $b > 0) { echo "either"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    // ── Loop statements ───────────────────────────────────────────────────────

    public function testWhileLoopGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { while ($a > 0) { $a--; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testDoWhileLoopGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(int $a): void { do { $a--; } while ($a > 0); }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testForLoopGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(): void { for ($i = 0; $i < 3; $i++) { echo $i; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testForeachLoopGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(array $items): void { foreach ($items as $item) { echo $item; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    // ── switch ────────────────────────────────────────────────────────────────

    public function testSwitchWithTwoCasesNoDefaultGivesNpathThree(): void
    {
        // 2 case stmts + 1 for no-default path
        $method = $this->parseMethod('public function foo(int $a): void { switch ($a) { case 1: echo "one"; break; case 2: echo "two"; break; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    public function testSwitchWithTwoCasesAndDefaultGivesNpathThree(): void
    {
        // 2 cases + 1 default = 3 paths
        $method = $this->parseMethod('public function foo(int $a): void { switch ($a) { case 1: echo "one"; break; case 2: echo "two"; break; default: echo "other"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    // ── try-catch ─────────────────────────────────────────────────────────────

    public function testTryCatchGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(): void { try { echo "ok"; } catch (\Exception $e) { echo "err"; } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testTryWithTwoCatchesGivesNpathThree(): void
    {
        $method = $this->parseMethod('public function foo(): void { try { echo "ok"; } catch (\RuntimeException $e) { echo "runtime"; } catch (\Exception $e) { echo "other"; } }');
        $this->assertSame(3, $this->calculator->calculate($method));
    }

    // ── return and expression paths ───────────────────────────────────────────

    public function testReturnWithTernaryGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(int $a): string { return $a > 0 ? "yes" : "no"; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testReturnWithNullCoalesceGivesNpathTwo(): void
    {
        $method = $this->parseMethod('public function foo(?int $a): int { return $a ?? 0; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testAssignmentWithNullCoalesceCountsInExpressionStatement(): void
    {
        $method = $this->parseMethod('public function foo(?int $a): void { $b = $a ?? 0; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    // ── match expression ──────────────────────────────────────────────────────

    public function testMatchWithThreeArmsNoDefaultGivesFourPaths(): void
    {
        // 3 arms + 1 for no-default (UnhandledMatchError)
        $method = $this->parseMethod('public function foo(int $a): string { return match($a) { 1 => "one", 2 => "two", 3 => "three" }; }');
        $this->assertSame(4, $this->calculator->calculate($method));
    }

    public function testMatchWithTwoArmsAndDefaultGivesTwoPaths(): void
    {
        $method = $this->parseMethod('public function foo(int $a): string { return match($a) { 1 => "one", default => "other" }; }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    // ── sequential multiplication ─────────────────────────────────────────────

    public function testTwoSequentialIfsMultiply(): void
    {
        $method = $this->parseMethod('public function foo(int $a, int $b): void { if ($a > 0) { echo "a"; } if ($b > 0) { echo "b"; } }');
        $this->assertSame(4, $this->calculator->calculate($method)); // 2 × 2
    }

    public function testThreeSequentialIfsMultiply(): void
    {
        $method = $this->parseMethod('public function foo(int $a, int $b, int $c): void { if ($a > 0) { echo "a"; } if ($b > 0) { echo "b"; } if ($c > 0) { echo "c"; } }');
        $this->assertSame(8, $this->calculator->calculate($method)); // 2 × 2 × 2
    }

    public function testEightSequentialIfsGiveNpath256(): void
    {
        $code = '
            public function foo(int $a, int $b, int $c, int $d, int $e, int $f, int $g, int $h): void {
                if ($a > 0) { echo "a"; }
                if ($b > 0) { echo "b"; }
                if ($c > 0) { echo "c"; }
                if ($d > 0) { echo "d"; }
                if ($e > 0) { echo "e"; }
                if ($f > 0) { echo "f"; }
                if ($g > 0) { echo "g"; }
                if ($h > 0) { echo "h"; }
            }
        ';
        $method = $this->parseMethod($code);
        $this->assertSame(256, $this->calculator->calculate($method)); // 2^8
    }

    // ── nested vs sequential ──────────────────────────────────────────────────

    public function testNestedIfIsAdditiveNotMultiplicative(): void
    {
        // Nested: if ($a) { if ($b) {} } → NPath = 0 + (0 + 1 + 1) + 1 = 3
        // Sequential: if ($a) {}; if ($b) {} → NPath = 2 × 2 = 4
        $nested = $this->parseMethod('public function foo(int $a, int $b): void { if ($a > 0) { if ($b > 0) { echo "both"; } } }');
        $this->assertSame(3, $this->calculator->calculate($nested));
    }

    // ── try-finally ───────────────────────────────────────────────────────────

    public function testTryFinallyWithNoBranchingDoesNotChangePaths(): void
    {
        // finally NPath = 1, so multiplying doesn't change the result
        $method = $this->parseMethod('public function foo(): void { try { echo "ok"; } finally { echo "done"; } }');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    public function testTryFinallyWithBranchingMultipliesNpath(): void
    {
        // try NPath = 1, finally NPath = 2 (the if) → 1 * 2 = 2
        $method = $this->parseMethod('public function foo(int $b): void { try { echo "ok"; } finally { if ($b > 0) { echo "b"; } } }');
        $this->assertSame(2, $this->calculator->calculate($method));
    }

    public function testTryCatchFinallyWithBranchingMultipliesAllPaths(): void
    {
        // try NPath = 1, catch NPath = 1 → additive = 2; finally NPath = 2 (the if) → 2 * 2 = 4
        $method = $this->parseMethod('public function foo(int $b): void { try { echo "ok"; } catch (\Exception $e) { echo "err"; } finally { if ($b > 0) { echo "b"; } } }');
        $this->assertSame(4, $this->calculator->calculate($method));
    }

    // ── overflow guard ────────────────────────────────────────────────────────

    public function testCalculationCapsAtPhpIntMaxToPreventOverflow(): void
    {
        // 63 sequential ifs would produce 2^63 > PHP_INT_MAX; the guard returns PHP_INT_MAX instead
        $ifs = implode(' ', array_fill(0, 63, 'if ($a > 0) { echo "x"; }'));
        $method = $this->parseMethod("public function foo(int \$a): void { {$ifs} }");
        $this->assertSame(PHP_INT_MAX, $this->calculator->calculate($method));
    }

    // ── closure / arrow function atomicity ───────────────────────────────────

    public function testClosureInsideMethodIsTreatedAsAtomicNpath(): void
    {
        $method = $this->parseMethod('public function foo(array $items): array { return array_filter($items, function($item) { if ($item > 0) { return true; } return false; }); }');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    public function testArrowFunctionInsideMethodIsTreatedAsAtomicNpath(): void
    {
        $method = $this->parseMethod('public function foo(array $items): array { return array_filter($items, fn($item) => $item > 0); }');
        $this->assertSame(1, $this->calculator->calculate($method));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

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
