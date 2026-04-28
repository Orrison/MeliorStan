<?php

namespace Orrison\MeliorStan\Rules\ExcessiveMethodLength;

class Config
{
    public function __construct(
        protected int $maximum = 100,
        protected bool $ignoreWhitespace = false,
        protected string $ignorePattern = '',
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }

    public function getIgnoreWhitespace(): bool
    {
        return $this->ignoreWhitespace;
    }

    public function getIgnorePattern(): string
    {
        return $this->ignorePattern;
    }
}
