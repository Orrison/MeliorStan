<?php

namespace Orrison\MeliorStan\Rules\PascalCaseClassName;

class Config
{
    public function __construct(
        protected bool $allowConsecutiveUppercase
    ) {}

    public function allowConsecutiveUppercase(): bool
    {
        return $this->allowConsecutiveUppercase;
    }
}
