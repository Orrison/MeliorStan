<?php

namespace Orrison\MeliorStan\Rules\ElseExpression;

class Config
{
    public function __construct(
        protected bool $elseifAllowed,
    ) {}

    public function getElseifAllowed(): bool
    {
        return $this->elseifAllowed;
    }
}
