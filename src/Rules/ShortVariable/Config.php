<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortVariable;

class Config
{
    public function __construct(
        private int $minimumLength = 3,
        /** @var string[] */
        private array $exceptions = [],
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
}
