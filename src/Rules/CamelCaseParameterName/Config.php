<?php

namespace Orrison\MessStan\Rules\CamelCaseParameterName;

class Config
{
    public function __construct(
        protected bool $allowConsecutiveUppercase = false,
        protected bool $allowUnderscorePrefix = false,
    ) {}

    public function getAllowConsecutiveUppercase(): bool
    {
        return $this->allowConsecutiveUppercase;
    }

    public function getAllowUnderscorePrefix(): bool
    {
        return $this->allowUnderscorePrefix;
    }
}
