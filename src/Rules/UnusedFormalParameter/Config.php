<?php

namespace Orrison\MeliorStan\Rules\UnusedFormalParameter;

class Config
{
    public function __construct(
        protected bool $allowUnusedWithInheritdoc = true,
        protected bool $allowOverridingMethods = true,
        /** @var string[] */
        protected array $exceptions = [],
    ) {}

    public function getAllowUnusedWithInheritdoc(): bool
    {
        return $this->allowUnusedWithInheritdoc;
    }

    public function getAllowOverridingMethods(): bool
    {
        return $this->allowOverridingMethods;
    }

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
