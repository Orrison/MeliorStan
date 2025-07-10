<?php

namespace Orrison\MessedUpPhpstan\Rules\CamelCaseParameterName;

class Config
{
    public function __construct(
        private bool $allowConsecutiveUppercase = false,
        private bool $allowUnderscorePrefix = false,
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
