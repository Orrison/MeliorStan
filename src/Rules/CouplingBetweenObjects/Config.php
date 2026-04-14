<?php

namespace Orrison\MeliorStan\Rules\CouplingBetweenObjects;

class Config
{
    /**
     * @param int $maximum Maximum number of unique type dependencies allowed.
     * @param array<string> $excludedNamespaces Namespace prefixes to exclude from coupling count.
     * @param array<string> $excludedTypes Specific FQCNs to exclude from coupling count.
     * @param bool $countAttributes Whether PHP 8 attributes count toward coupling.
     */
    public function __construct(
        protected int $maximum,
        protected array $excludedNamespaces,
        protected array $excludedTypes,
        protected bool $countAttributes,
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
    public function getExcludedTypes(): array
    {
        return $this->excludedTypes;
    }

    public function getCountAttributes(): bool
    {
        return $this->countAttributes;
    }
}
