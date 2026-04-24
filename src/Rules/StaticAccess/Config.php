<?php

namespace Orrison\MeliorStan\Rules\StaticAccess;

class Config
{
    /**
     * @param array<string> $exceptions List of fully-qualified class names or wildcard patterns to exclude from static access checks.
     * @param string $methodIgnorePattern Regular expression pattern for method names to ignore.
     * @param string $propertyIgnorePattern Regular expression pattern for property names to ignore.
     * @param bool $checkStaticPropertyAccess Whether to also flag static property access.
     */
    public function __construct(
        protected array $exceptions,
        protected string $methodIgnorePattern,
        protected string $propertyIgnorePattern,
        protected bool $checkStaticPropertyAccess,
    ) {}

    /**
     * @return array<string>
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    public function getMethodIgnorePattern(): string
    {
        return $this->methodIgnorePattern;
    }

    public function getPropertyIgnorePattern(): string
    {
        return $this->propertyIgnorePattern;
    }

    public function getCheckStaticPropertyAccess(): bool
    {
        return $this->checkStaticPropertyAccess;
    }

    public function isExcepted(string $className): bool
    {
        foreach ($this->exceptions as $exception) {
            if (fnmatch($exception, $className, FNM_NOESCAPE)) {
                return true;
            }
        }

        return false;
    }
}
