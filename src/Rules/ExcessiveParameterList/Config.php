<?php

namespace Orrison\MeliorStan\Rules\ExcessiveParameterList;

class Config
{
    public function __construct(
        protected int $maximum = 10,
        protected string $ignorePattern = '',
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
