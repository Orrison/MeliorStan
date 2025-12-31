<?php

namespace Orrison\MeliorStan\Rules\CyclomaticComplexity;

class Config
{
    public function __construct(
        protected int $reportLevel = 10,
        protected bool $showClassesComplexity = true,
        protected bool $showMethodsComplexity = true,
    ) {}

    public function getReportLevel(): int
    {
        return $this->reportLevel;
    }

    public function getShowClassesComplexity(): bool
    {
        return $this->showClassesComplexity;
    }

    public function getShowMethodsComplexity(): bool
    {
        return $this->showMethodsComplexity;
    }
}
