<?php

namespace Orrison\MeliorStan\Rules\CamelCasePropertyName;

class Config
{
    public function __construct(
        protected bool $allowConsecutiveUppercase = false,
        protected bool $allowUnderscorePrefix = false,
        /** @var string[] */
        protected array $ignoredWhenInClasses = [],
        /** @var string[] */
        protected array $ignoredWhenInClassesDescendantOf = [],
    ) {}

    public function getAllowConsecutiveUppercase(): bool
    {
        return $this->allowConsecutiveUppercase;
    }

    public function getAllowUnderscorePrefix(): bool
    {
        return $this->allowUnderscorePrefix;
    }

    /**
     * @return string[]
     */
    public function getIgnoredWhenInClasses(): array
    {
        return $this->ignoredWhenInClasses;
    }

    /**
     * @return string[]
     */
    public function getIgnoredWhenInClassesDescendantOf(): array
    {
        return $this->ignoredWhenInClassesDescendantOf;
    }
}
