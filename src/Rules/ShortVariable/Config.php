<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortVariable;

class Config
{
    public function __construct(
        private int $minimumLength = 3,
        /** @var string[] */
        private array $exceptions = [],
        private bool $allowInForLoops = false,
        private bool $allowInForeach = false,
        private bool $allowInCatch = false,
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
