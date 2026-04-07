<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class PromotedConstructor
{
    public function __construct(
        public int $x,
        protected string $y,
        private float $z,
    ) {}
}
