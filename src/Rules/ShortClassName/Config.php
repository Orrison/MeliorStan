<?php

namespace Orrison\MeliorStan\Rules\ShortClassName;

class Config
{
    public function __construct(
        protected int $minimum = 3,
        /** @var string[] */
        protected array $exceptions = [],
    ) {}

    public function getMinimum(): int
    {
        return $this->minimum;
    }

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
