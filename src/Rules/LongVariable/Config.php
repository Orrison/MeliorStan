<?php

namespace Orrison\MeliorStan\Rules\LongVariable;

class Config
{
    /**
     * @param int $maximum
     * @param string[] $subtractPrefixes
     * @param string[] $subtractSuffixes
     * @param bool $allowInForLoops
     * @param bool $allowInForeach
     * @param bool $allowInCatch
     * @param string[] $exceptions
     */
    public function __construct(
        protected int $maximum,
        protected array $subtractPrefixes,
        protected array $subtractSuffixes,
        protected bool $allowInForLoops,
        protected bool $allowInForeach,
        protected bool $allowInCatch,
        protected array $exceptions,
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }

    /**
     * @return string[]
     */
    public function getSubtractPrefixes(): array
    {
        return $this->subtractPrefixes;
    }

    /**
     * @return string[]
     */
    public function getSubtractSuffixes(): array
    {
        return $this->subtractSuffixes;
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

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
