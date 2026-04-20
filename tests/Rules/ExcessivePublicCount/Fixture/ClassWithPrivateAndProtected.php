<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * Many private/protected members that must NOT be counted toward the public
 * count. Only 3 public members total, so this must pass under every default-
 * threshold test.
 */
class ClassWithPrivateAndProtected
{
    public int $publicOne = 0;

    protected int $protectedOne = 0;

    protected int $protectedTwo = 0;

    protected int $protectedThree = 0;

    protected int $protectedFour = 0;

    private int $privateOne = 0;

    private int $privateTwo = 0;

    private int $privateThree = 0;

    private int $privateFour = 0;

    private int $privateFive = 0;

    public function publicMethod(): void {}

    public function anotherPublicMethod(): void {}

    protected function protectedMethod(): void {}

    protected function anotherProtectedMethod(): void {}

    private function privateMethod(): void {}

    private function anotherPrivateMethod(): void {}
}
