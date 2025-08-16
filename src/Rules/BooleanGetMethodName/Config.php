<?php

namespace Orrison\MeliorStan\Rules\BooleanGetMethodName;

class Config
{
    public function __construct(
        protected bool $checkParameterizedMethods = false,
    ) {
    }

    public function getCheckParameterizedMethods(): bool
    {
        return $this->checkParameterizedMethods;
    }
}
