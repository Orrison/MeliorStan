<?php

namespace Orrison\MeliorStan\Rules\BooleanArgumentFlag;

class Config
{
    /**
     * @param array<string> $ignoredInClasses
     * @param string $ignorePattern
     */
    public function __construct(
        protected array $ignoredInClasses,
        protected string $ignorePattern,
    ) {}

    /**
     * @return array<string>
     */
    public function getIgnoredInClasses(): array
    {
        return $this->ignoredInClasses;
    }

    public function getIgnorePattern(): string
    {
        return $this->ignorePattern;
    }
}
