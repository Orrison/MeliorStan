<?php

namespace Orrison\MeliorStan\Rules\TooManyMethods;

class Config
{
    public function __construct(
        protected int $maxMethods = 25,
        protected string $ignorePattern = '^(get|set|is)',
    ) {}

    public function getMaxMethods(): int
    {
        return $this->maxMethods;
    }

    public function getIgnorePattern(): string
    {
        return $this->ignorePattern;
    }
}
