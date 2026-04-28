<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity\Fixture;

interface HighComplexityInterface
{
    public function methodOne(int $a): void;

    public function methodTwo(int $a): void;

    public function methodThree(int $a): void;

    public function methodFour(int $a): void;

    public function methodFive(int $a): void;

    public function methodSix(int $a): void;
}
