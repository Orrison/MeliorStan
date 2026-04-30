<?php

namespace Orrison\MeliorStan\Rules\CognitiveComplexity;

class Config
{
    public function __construct(
        protected int $methodMaximum = 15,
        protected int $classMaximum = 50,
        protected string $ignorePattern = '',
    ) {}

    public function getMethodMaximum(): int
    {
        return $this->methodMaximum;
    }

    public function getClassMaximum(): int
    {
        return $this->classMaximum;
    }

    public function getIgnorePattern(): string
    {
        return $this->ignorePattern;
    }
}
