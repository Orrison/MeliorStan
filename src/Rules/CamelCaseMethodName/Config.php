<?php

namespace Orrison\MessStan\Rules\CamelCaseMethodName;

class Config
{
    public function __construct(
        protected bool $allowConsecutiveUppercase = false,
        protected bool $allowUnderscoreInTests = false,
        protected bool $allowUnderscorePrefix = false,
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
