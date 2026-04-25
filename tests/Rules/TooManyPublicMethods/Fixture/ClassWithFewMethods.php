<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods\Fixture;

// 3 plain public methods + getters/setters (ignored by default) — no error
class ClassWithFewMethods
{
    public function process(): void {}

    public function validate(): void {}

    public function execute(): void {}

    public function getName(): string
    {
        return '';
    }

    public function setName(string $name): void {}

    public function isActive(): bool
    {
        return true;
    }

    protected function internalHelper(): void {}

    private function privateMethod(): void {}
}
