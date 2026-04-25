<?php

namespace Orrison\MeliorStan\Rules\TooManyPublicMethods;

class Config
{
    public function __construct(
        protected int $maxMethods = 10,
        protected string $ignorePattern = '^(get|set|is)',
        protected bool $ignoreMagicMethods = true,
    ) {}

    public function getMaxMethods(): int
    {
        return $this->maxMethods;
    }

    public function getIgnorePattern(): string
    {
        return $this->ignorePattern;
    }

    public function getIgnoreMagicMethods(): bool
    {
        return $this->ignoreMagicMethods;
    }
}
