<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength\Fixture;

$emlShortClosure = function (): void {
    $a = 1;
    $b = 2;
};

$emlLongClosure = function (): void {
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
};
