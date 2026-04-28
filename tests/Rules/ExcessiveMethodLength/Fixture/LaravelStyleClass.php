<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength\Fixture;

class LaravelStyleClass
{
    public function boot(): void
    {
        $x1 = 1;
        $x2 = 2;
        $x3 = 3;
        $x4 = 4;
        $x5 = 5;
        $x6 = 6;
        $x7 = 7;
        $x8 = 8;
        $x9 = 9;
        $x10 = 10;
    }

    public function up(): void
    {
        $x1 = 1;
        $x2 = 2;
        $x3 = 3;
        $x4 = 4;
        $x5 = 5;
        $x6 = 6;
        $x7 = 7;
        $x8 = 8;
        $x9 = 9;
        $x10 = 10;
    }

    public function notIgnoredMethod(): void
    {
        $x1 = 1;
        $x2 = 2;
        $x3 = 3;
        $x4 = 4;
        $x5 = 5;
        $x6 = 6;
        $x7 = 7;
        $x8 = 8;
        $x9 = 9;
        $x10 = 10;
    }
}
