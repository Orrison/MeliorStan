<?php

namespace Orrison\MessedUpPhpstan\Rules\PascalCaseClassName;

class Config
{
    public function __construct(
        private bool $camelcaseAbbreviations
    ) {}

    public function getCamelcaseAbbreviations(): bool
    {
        return $this->camelcaseAbbreviations;
    }
}