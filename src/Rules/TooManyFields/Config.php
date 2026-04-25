<?php

namespace Orrison\MeliorStan\Rules\TooManyFields;

class Config
{
    public function __construct(
        protected int $maxFields = 15,
        protected bool $ignoreStaticProperties = true,
    ) {}

    public function getMaxFields(): int
    {
        return $this->maxFields;
    }

    public function getIgnoreStaticProperties(): bool
    {
        return $this->ignoreStaticProperties;
    }
}
