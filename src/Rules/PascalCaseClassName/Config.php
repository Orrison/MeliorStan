<?php

namespace Orrison\MessedUpPhpstan\Rules\PascalCaseClassName;

class Config
{
    public function __construct(
        private bool $pascalCaseAbbreviations
    ) {}

    public function getPascalCaseAbbreviations(): bool
    {
        return $this->pascalCaseAbbreviations;
    }
}