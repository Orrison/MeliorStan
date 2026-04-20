<?php

namespace Orrison\MeliorStan\Rules\ExcessivePublicCount;

class Config
{
    public function __construct(
        protected int $maximum = 45,
        protected string $ignorePattern = '^(get|set|is)',
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }

    public function getIgnorePattern(): string
    {
        return $this->ignorePattern;
    }
}
