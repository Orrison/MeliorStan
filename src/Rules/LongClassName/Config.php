<?php

namespace Orrison\MeliorStan\Rules\LongClassName;

class Config
{
    public function __construct(
        protected int $maximum,
        /** @var string[] */
        protected array $subtractPrefixes,
        /** @var string[] */
        protected array $subtractSuffixes
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }

    /** @return string[] */
    public function getSubtractPrefixes(): array
    {
        return $this->subtractPrefixes;
    }

    /** @return string[] */
    public function getSubtractSuffixes(): array
    {
        return $this->subtractSuffixes;
    }
}
