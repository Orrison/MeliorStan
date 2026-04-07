<?php

namespace Orrison\MeliorStan\Rules\UnusedLocalVariable;

class Config
{
    public function __construct(
        protected bool $allowUnusedForeachVariables = false,
        /** @var string[] */
        protected array $exceptions = [],
    ) {}

    public function getAllowUnusedForeachVariables(): bool
    {
        return $this->allowUnusedForeachVariables;
    }

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
