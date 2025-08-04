<?php

namespace Orrison\MessedUpPhpstan\Rules\ShortProperty;

class Config
{
    public function __construct(
        protected int $minimumLength = 3,
        /** @var string[] */
        protected array $exceptions = [],
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
