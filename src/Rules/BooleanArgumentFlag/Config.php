<?php

namespace Orrison\MeliorStan\Rules\BooleanArgumentFlag;

class Config
{
    /**
     * @param array<string> $ignoredInClasses List of fully-qualified class names in which boolean argument flag checks should be ignored.
     * @param string $ignorePattern Regular expression pattern for method names to ignore.
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
