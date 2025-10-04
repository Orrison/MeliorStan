<?php

namespace Orrison\MeliorStan\Rules\NumberOfChildren;

class Config
{
    public function __construct(
        protected int $maximum
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }
}
