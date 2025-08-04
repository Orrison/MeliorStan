<?php

namespace Orrison\MessedUpPhpstan\Rules\LongClassName;

class Config
{
    public function __construct(
        protected int $maximum,
        protected array $subtractPrefixes,
        protected array $subtractSuffixes
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }

    public function getSubtractPrefixes(): array
    {
        return $this->subtractPrefixes;
    }

    public function getSubtractSuffixes(): array
    {
        return $this->subtractSuffixes;
    }
}