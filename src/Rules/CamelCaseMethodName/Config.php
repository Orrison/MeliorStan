<?php

namespace Orrison\MessedUpPhpstan\Rules\CamelCaseMethodName;

class Config
{
    public function __construct(
        private bool $allowConsecutiveUppercase = false,
        private bool $allowUnderscoreInTests = false,
        private bool $allowUnderscorePrefix = false,
    ) {}

    public function getAllowConsecutiveUppercase(): bool
    {
        return $this->allowConsecutiveUppercase;
    }

    public function getAllowUnderscoreInTests(): bool
    {
        return $this->allowUnderscoreInTests;
    }

    public function getAllowUnderscorePrefix(): bool
    {
        return $this->allowUnderscorePrefix;
    }
}
