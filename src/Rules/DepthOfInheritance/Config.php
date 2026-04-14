<?php

namespace Orrison\MeliorStan\Rules\DepthOfInheritance;

class Config
{
    /**
     * @param int $maximum Maximum allowed inheritance depth.
     * @param array<string> $excludedNamespaces Namespace prefixes whose ancestors don't count toward depth.
     * @param array<string> $ignoredClasses FQCNs of classes to skip entirely.
     */
    public function __construct(
        protected int $maximum,
        protected array $excludedNamespaces,
        protected array $ignoredClasses,
    ) {}

    public function getMaximum(): int
    {
        return $this->maximum;
    }

    /**
     * @return array<string>
     */
    public function getExcludedNamespaces(): array
    {
        return $this->excludedNamespaces;
    }

    /**
     * @return array<string>
     */
    public function getIgnoredClasses(): array
    {
        return $this->ignoredClasses;
    }
}
