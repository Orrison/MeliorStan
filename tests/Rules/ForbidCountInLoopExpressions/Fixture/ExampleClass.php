<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidCountInLoopExpressions\Fixture;

class ExampleClass
{
    public function validLoopWithCachedCount(): void
    {
        $items = [1, 2, 3];
        $count = count($items);

        for ($i = 0; $i < $count; $i++) {
            echo $items[$i];
        }
    }

    public function validCountOutsideLoop(): void
    {
        $items = [1, 2, 3];
        $total = count($items);
        echo $total;
    }

    public function invalidForLoop(): void
    {
        $items = [1, 2, 3];

        for ($i = 0; $i < count($items); $i++) {
            echo $items[$i];
        }
    }

    public function invalidWhileLoop(): void
    {
        $items = [1, 2, 3];
        $i = 0;

        while ($i < count($items)) {
            echo $items[$i++];
        }
    }

    public function invalidDoWhileLoop(): void
    {
        $items = [1, 2, 3];
        $i = 0;

        do {
            echo $items[$i++];
        } while ($i < sizeof($items));
    }

    public function invalidForLoopWithComplexCondition(): void
    {
        $items = [1, 2, 3];

        for ($i = 0; $i < count($items) - 1; $i++) {
            echo $items[$i];
        }
    }

    public function invalidForLoopWithMultipleConditions(): void
    {
        $items = [1, 2, 3];
        $others = [4, 5, 6];

        for ($i = 0; $i < count($items) && $i < 10; $i++) {
            echo $items[$i];
        }
    }

    public function nestedLoopsWithCount(): void
    {
        $matrix = [[1, 2], [3, 4]];

        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                echo $matrix[$i][$j];
            }
        }
    }

    public function countInLoopBody(): void
    {
        $items = [1, 2, 3];

        for ($i = 0; $i < 3; $i++) {
            $total = count($items);
            echo $total;
        }
    }

    public function sizeofInsteadOfCount(): void
    {
        $items = [1, 2, 3];

        for ($i = 0; $i < sizeof($items); $i++) {
            echo $items[$i];
        }
    }

    public function whileLoopWithSizeof(): void
    {
        $items = [1, 2, 3];
        $i = 0;

        while ($i < sizeof($items)) {
            echo $items[$i++];
        }
    }
}
