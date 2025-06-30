<?php

namespace Orrison\MessedUpPhpstan\Rules\PascalCaseClassName;

class Config
{
    public function __construct(
        private bool $allowConsecutiveUppercase
    ) {}

    public function allowConsecutiveUppercase(): bool
    {
        return $this->allowConsecutiveUppercase;
    }
}