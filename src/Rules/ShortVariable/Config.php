<?php

namespace Orrison\MeliorStan\Rules\ShortVariable;

class Config
{
    public function __construct(
        protected int $minimumLength = 3,
        /** @var string[] */
        protected array $exceptions = [],
        protected bool $allowInForLoops = false,
        protected bool $allowInForeach = false,
        protected bool $allowInCatch = false,
    ) {}

    public function getMinimumLength(): int
    {
        return $this->minimumLength;
    }

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    public function getAllowInForLoops(): bool
    {
        return $this->allowInForLoops;
    }

    public function getAllowInForeach(): bool
    {
        return $this->allowInForeach;
    }

    public function getAllowInCatch(): bool
    {
        return $this->allowInCatch;
    }
}
