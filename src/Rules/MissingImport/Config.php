<?php

namespace Orrison\MeliorStan\Rules\MissingImport;

class Config
{
    /**
     * @param string[] $exceptions
     */
    public function __construct(
        protected bool $ignoreGlobal,
        protected array $exceptions,
    ) {}

    public function getIgnoreGlobal(): bool
    {
        return $this->ignoreGlobal;
    }

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
